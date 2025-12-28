@extends('admin.layout')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Tableau de bord</h2>
        <p class="text-gray-500">Vue d'ensemble de votre boutique.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Commandes Aujourd'hui</div>
            <div class="text-3xl font-bold text-gray-800">{{ $stats['today_orders'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Commandes ce mois</div>
            <div class="text-3xl font-bold text-blue-600">{{ $stats['month_orders'] }}</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Revenu ce mois</div>
            <div class="text-3xl font-bold text-green-600">{{ number_format($stats['month_revenue'], 0, ',', ' ') }} <span class="text-sm text-gray-400">DA</span></div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Produits Actifs</div>
            <div class="text-3xl font-bold text-purple-600">{{ \App\Models\Product::where('is_active', true)->count() }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Dernières Commandes</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Client</th>
                            <th class="px-6 py-3">Produit</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recent_orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <div>{{ $order->customer_name }} {{ $order->customer_firstname }}</div>
                                <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $order->product->name }}</td>
                            <td class="px-6 py-4 font-bold">{{ number_format($order->total_price, 0) }} DA</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $order->status === 'new' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $order->status === 'fake' ? 'bg-gray-900 text-white' : '' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucune commande pour le moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir toutes les commandes →</a>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Top Produits</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    @forelse($top_products as $product)
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $product->main_image) }}" class="w-12 h-12 rounded-lg object-cover bg-gray-100" alt="">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 line-clamp-1">{{ $product->name }}</h4>
                            <div class="text-sm text-gray-500">{{ $product->orders_count }} ventes</div>
                        </div>
                        <div class="font-bold text-gray-800">{{ number_format($product->price, 0) }} DA</div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">Aucun produit vendu.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
