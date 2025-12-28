@extends('layouts.front')

@push('head')
<script>
    // Facebook Purchase Event
    @if(\App\Models\Setting::where('key', 'facebook_pixel_id')->value('value'))
    fbq('track', 'Purchase', {
        content_name: '{{ $order->product->name }}',
        content_ids: ['{{ $order->product->id }}'],
        content_type: 'product',
        value: {{ $order->total_price }},
        currency: 'DZD',
        order_id: '{{ $order->order_number }}'
    });
    @endif
</script>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Merci pour votre commande !</h2>
            <p class="text-gray-600 mb-6">Votre commande #{{ $order->order_number }} a été enregistrée avec succès.</p>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <p class="text-sm text-gray-500 mb-1">Un de nos agents vous appellera bientôt sur :</p>
                <p class="text-lg font-bold text-gray-900">{{ $order->customer_phone }}</p>
                <p class="text-sm text-gray-500 mt-2">pour confirmer votre adresse de livraison.</p>
            </div>

            <div class="space-y-4">
                 <a href="{{ route('home') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Retour à la boutique
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
