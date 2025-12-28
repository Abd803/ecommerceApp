@extends('layouts.front')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900">جميع المنتجات</h1>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span>الترتيب حسب:</span>
                <select class="border-none bg-transparent font-medium text-gray-700 focus:ring-0">
                    <option>الأحدث</option>
                    <option>السعر: من الأقل للأعلى</option>
                    <option>السعر: من الأعلى للأقل</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden border border-gray-100 flex flex-col">
                <!-- Image -->
                <a href="{{ route('front.product.show', $product->slug) }}" class="block relative aspect-w-1 aspect-h-1">
                    @if($product->main_image)
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-64 object-contain p-4 hover:scale-105 transition duration-500">
                    @else
                         <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                    <!-- Badge (Optional) -->
                    <!-- <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">PROMO</span> -->
                </a>

                <!-- Content -->
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 h-10">
                        <a href="{{ route('front.product.show', $product->slug) }}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    
                    <div class="mt-auto">
                         <!-- Price -->
                        <div class="flex items-center justify-center mb-3">
                            <span class="text-lg font-bold text-orange-600" dir="ltr">{{ number_format($product->price, 0, ',', ' ') }} د.ج</span>
                            <!-- <span class="text-xs text-gray-400 line-through mr-2">2500 د.ج</span> -->
                        </div>

                        <!-- Button -->
                        <a href="{{ route('front.product.show', $product->slug) }}" class="block w-full text-center border border-orange-500 text-orange-600 font-bold py-2 rounded hover:bg-orange-500 hover:text-white transition">
                            شراء الآن
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
