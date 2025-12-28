<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'month_orders' => Order::whereMonth('created_at', now()->month)->count(),
            'month_revenue' => Order::whereMonth('created_at', now()->month)
                ->where('status', '!=', 'cancelled')
                ->where('status', '!=', 'fake')
                ->sum('total_price'),
            'conversion_rate' => 'N/A', // Need visitor tracking for this
        ];

        $recent_orders = Order::with('product')->latest()->take(5)->get();
        
        $top_products = Product::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products'));
    }
}
