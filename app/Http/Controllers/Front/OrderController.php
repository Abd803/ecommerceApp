<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Services\FraudDetectionService;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request, FraudDetectionService $fraudService, GoogleSheetsService $sheetsService)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_slug' => 'required|exists:products,slug', // Extra check
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^(05|06|07)[0-9]{8}$/'],
            'wilaya' => 'required|exists:wilayas,code',
            'commune' => 'nullable|string', // Optional
            'quantity' => 'required|integer|min:1|max:10',
            'selected_model' => 'nullable|string'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!empty($product->available_models) && empty($validated['selected_model'])) {
             return response()->json(['success' => false, 'message' => 'Veuillez sélectionner un modèle.'], 422);
        }

        // Fraud Check
        $fraudResult = $fraudService->check($request);
        
        $quantity = (int) $validated['quantity'];
        $totalPrice = $product->price * $quantity;
        // Delivery fee calculation could be added here later

        $order = Order::create([
            'order_number' => 'CMD-' . strtoupper(Str::random(10)),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'selected_model' => $validated['selected_model'] ?? null,
            'customer_name' => $validated['nom'],
            'customer_firstname' => $validated['prenom'],
            'customer_phone' => $validated['telephone'],
            'customer_wilaya' => $validated['wilaya'], // Storing Code initially, ideally Name
            'total_price' => $totalPrice, 
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_suspected_fraud' => $fraudResult['is_fraud'],
        ]);

        if ($fraudResult['score'] > 0) {
            $fraudService->logFraud($request, $fraudResult['reasons'], $fraudResult['score'], $order->id);
        }

        // Sync to google sheets immediately
        $sheetsService->addOrder($order);

        return response()->json([
            'success' => true, 
            'redirect_url' => route('front.thankyou', ['order' => $order->id])
        ]);
    }
    
    public function thankYou(Order $order) {
        return view('front.thank-you', compact('order'));
    }
}
