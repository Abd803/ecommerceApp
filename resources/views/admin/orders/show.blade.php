@extends('admin.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700">← Retour aux commandes</a>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">Commande #{{ $order->order_number }}</h2>
            <div class="text-sm text-gray-500">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</div>
        </div>
        
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex items-center gap-4 bg-white p-4 rounded-lg shadow-sm border">
            @csrf
            @method('PUT')
            <select name="status" class="border rounded-lg px-4 py-2 font-medium {{ $order->status === 'confirmed' ? 'text-green-600' : '' }}">
                <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>Nouvelle</option>
                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>En préparation</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Expédiée</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Livrée</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                <option value="fake" {{ $order->status == 'fake' ? 'selected' : '' }}>Fake</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Mettre à jour</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Customer Info -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Informations Client</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-gray-500 text-sm">Nom complet</span>
                    <div class="font-medium">{{ $order->customer_name }} {{ $order->customer_firstname }}</div>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">Téléphone</span>
                    <div class="font-medium text-lg">{{ $order->customer_phone }}</div>
                    <a href="tel:{{ $order->customer_phone }}" class="text-blue-600 text-sm hover:underline">Appeler</a>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">Wilaya</span>
                    <div class="font-medium">{{ $order->customer_wilaya }}</div>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">IP Address</span>
                    <div class="font-mono text-xs text-gray-600">{{ $order->ip_address }}</div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Détails Commande</h3>
            <div class="flex gap-4 items-start mb-6">
                <img src="{{ asset('storage/' . $order->product->main_image) }}" class="w-16 h-16 rounded-md object-cover bg-gray-100" alt="">
                <div>
                    <div class="font-medium">{{ $order->product->name }}</div>
                    <div class="text-sm text-gray-500">Réf Produit: {{ $order->product->id }}</div>
                    @if($order->selected_model)
                        <div class="mt-1">
                            <span class="bg-orange-100 text-orange-800 text-xs font-bold px-2 py-1 rounded uppercase">Modèle: {{ $order->selected_model }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="border-t pt-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Prix Unitaire</span>
                    <span>{{ number_format($order->product->price, 0) }} DA</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Livraison</span>
                    <span>included</span> <!-- Or dynamic if you implemented delivery fees -->
                </div>
                <div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
                    <span>Total</span>
                    <span>{{ number_format($order->total_price, 0) }} DA</span>
                </div>
            </div>
        </div>

        <!-- Fraud Analysis / Notes -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-lg text-gray-800 mb-4">Notes & Risque</h3>
            
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Notes Admin</label>
                    <textarea name="admin_notes" rows="4" class="w-full border rounded-lg px-4 py-2 text-sm">{{ $order->admin_notes }}</textarea>
                </div>
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">Sauvegarder la note</button>
            </form>

            @if($order->is_suspected_fraud)
                <div class="mt-6 bg-red-50 p-4 rounded-lg border border-red-100">
                    <h4 class="text-red-800 font-bold flex items-center gap-2">
                        <span>⚠️</span> Risque de Fraude Détecté
                    </h4>
                    <ul class="text-sm text-red-700 mt-2 list-disc list-inside">
                        @foreach($order->fraudLogs as $log)
                            <li>{{ $log->fraud_reason }} (Score: {{ $log->fraud_score }})</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="mt-6 bg-green-50 p-4 rounded-lg border border-green-100 text-green-800 text-sm">
                    ✅ Aucun risque détecté par le système.
                </div>
            @endif
        </div>
    </div>
@endsection
