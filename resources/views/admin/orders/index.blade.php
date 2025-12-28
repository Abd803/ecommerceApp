@extends('admin.layout')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Gestion des Commandes</h2>
        
        <form method="GET" class="flex gap-4">
            <select name="status" class="border rounded-lg px-4 py-2" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Nouvelles</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmées</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Expédiées</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Livrées</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulées</option>
                <option value="fake" {{ request('status') == 'fake' ? 'selected' : '' }}>Fake/Fraud</option>
            </select>
            <input type="text" name="search" placeholder="Recherche..." value="{{ request('search') }}" 
                   class="border rounded-lg px-4 py-2 w-64">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg">Filtrer</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">Réf</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Client</th>
                    <th class="px-6 py-3">Produit</th>
                    <th class="px-6 py-3">Qté / Modèle</th>
                    <th class="px-6 py-3">Wilaya</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Statut</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition {{ $order->is_suspected_fraud ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4 font-mono text-sm text-gray-600">
                        {{ $order->order_number }}
                        @if($order->is_suspected_fraud)
                            <span class="block text-xs text-red-600 font-bold">⚠️ SUSPECT</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $order->customer_name }} {{ $order->customer_firstname }}</div>
                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                        <div class="text-xs text-gray-500">{{ $order->customer_phone }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->product->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <span class="font-bold">{{ $order->quantity }}</span>
                        @if($order->selected_model)
                            <div class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded inline-block mt-1 uppercase">{{ $order->selected_model }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->customer_wilaya }}</td>
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
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1 rounded-md text-sm font-medium">Détails</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">Aucune commande trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-100">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
@endsection
