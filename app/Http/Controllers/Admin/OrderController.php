<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Services\GoogleSheetsService;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('product')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%$search%")
                  ->orWhere('customer_name', 'like', "%$search%")
                  ->orWhere('customer_phone', 'like', "%$search%");
            });
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['product', 'fraudLogs']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order, GoogleSheetsService $sheetsService)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,confirmed,preparing,shipped,delivered,cancelled,fake',
            'admin_notes' => 'nullable|string'
        ]);

        $previousStatus = $order->status;
        $order->update($validated);

        // Sync to Sheets if confirmed and status changed (example logic)
        if ($order->status === 'confirmed' && $previousStatus !== 'confirmed') {
            $sheetsService->addOrder($order);
        }

        return back()->with('success', 'Commande mise à jour.');
    }
}
