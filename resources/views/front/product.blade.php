@extends('layouts.front')

@push('head')
<script>
    @if(\App\Models\Setting::where('key', 'facebook_pixel_id')->value('value'))
    fbq('track', 'ViewContent', {
        content_name: '{{ $product->name }}',
        content_ids: ['{{ $product->id }}'],
        content_type: 'product',
        value: {{ $product->price }},
        currency: 'DZD'
    });
    @endif
</script>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen py-8" x-data="productPage()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-orange-600">الرئيسية</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $product->name }}</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
            
            <!-- Right Column: Info & Form (In RTL, this comes first in DOM if we want it on Right? Wait. 
                 In RTL, Grid Col 1 is Right, Grid Col 2 is Left. 
                 So yes, Info first.) -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                
                <div class="mt-3">
                    <p class="text-3xl text-orange-600 font-bold" dir="ltr">{{ number_format($product->price, 0, ',', ' ') }} د.ج</p>
                </div>

                <div class="mt-6">
                    <p class="text-base text-gray-700 leading-relaxed">{{ $product->short_description }}</p>
                </div>

                <!-- Features -->
                @if($product->features)
                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-bold text-gray-900">المميزات:</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach($product->features as $feature)
                        <li class="flex items-center text-sm text-gray-600">
                            <span class="text-green-500 ml-2">✔</span>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Models Selector -->
                @if($product->available_models)
                <div class="mt-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-2">اختر الموديل / اللون:</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->available_models as $model)
                        <button type="button" 
                                @click="selectedModel = '{{ $model }}'"
                                :class="{'ring-2 ring-orange-500 bg-orange-50 text-orange-700': selectedModel === '{{ $model }}', 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50': selectedModel !== '{{ $model }}'}"
                                class="border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase sm:flex-1 cursor-pointer focus:outline-none shadow-sm w-full sm:w-auto">
                            {{ $model }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Order Form Buider -->
                <div class="mt-8 bg-white p-6 rounded-2xl shadow-lg border border-orange-100" id="order-form">
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">الكمية:</label>
                        <div class="flex items-center w-32 border border-gray-300 rounded-lg">
                            <button @click="qty > 1 ? qty-- : null" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 rounded-r-lg">-</button>
                            <input type="text" x-model="qty" readonly class="w-12 h-10 text-center border-none focus:ring-0 text-gray-900 font-bold">
                            <button @click="qty < 10 ? qty++ : null" class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 rounded-l-lg">+</button>
                        </div>
                    </div>

                    <form @submit.prevent="submitOrder" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الاسم *</label>
                            <input type="text" x-model="formData.nom" required class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 px-4 py-2" placeholder="الاسم العائلي">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">اللقب *</label>
                            <input type="text" x-model="formData.prenom" required class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 px-4 py-2" placeholder="الاسم الشخصي">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف *</label>
                            <input type="tel" x-model="formData.telephone" required class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 px-4 py-2 text-left" dir="ltr" placeholder="05XXXXXXXX">
                            <p x-show="errors.telephone" class="text-red-500 text-xs mt-1" x-text="errors.telephone"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">الولاية *</label>
                                <select x-model="formData.wilaya" required class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 px-4 py-2">
                                    <option value="">اختر الولاية</option>
                                    @foreach($wilayas as $wilaya)
                                        <option value="{{ $wilaya->code }}">{{ $wilaya->code }} - {{ $wilaya->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">البلدية</label>
                                <input type="text" x-model="formData.commune" class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 px-4 py-2">
                            </div>
                        </div>

                        <!-- Total Price Dynamic -->
                        <div class="flex justify-between items-center py-4 border-t border-gray-100 mt-4">
                            <span class="font-bold text-gray-800">الإجمالي:</span>
                            <span class="text-xl font-bold text-orange-600" dir="ltr" x-text="formatPrice({{ $product->price }} * qty) + ' د.ج'"></span>
                        </div>

                        <button type="submit" :disabled="loading" class="w-full bg-orange-600 text-white font-bold py-3 rounded-lg hover:bg-orange-700 transition shadow-lg disabled:opacity-50 flex justify-center items-center">
                            <span x-show="!loading">شراء الآن (الدفع عند الاستلام)</span>
                            <span x-show="loading" class="animate-spin ml-2">⏳</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Left Column: Gallery (In RTL, Grid Col 2 is Left) -->
            <div class="flex flex-col">
                <div class="w-full aspect-w-1 aspect-h-1 bg-white rounded-2xl overflow-hidden shadow-sm mb-4">
                    <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-center object-contain p-4">
                </div>
                
                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-4">
                    <button @click="activeImage = '{{ asset('storage/' . $product->main_image) }}'" 
                            class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border-2"
                            :class="activeImage === '{{ asset('storage/' . $product->main_image) }}' ? 'border-orange-500' : 'border-transparent'">
                        <img src="{{ asset('storage/' . $product->main_image) }}" class="w-full h-full object-center object-cover">
                    </button>
                    @if($product->secondary_images)
                        @foreach($product->secondary_images as $img)
                        <button @click="activeImage = '{{ asset('storage/' . $img) }}'" 
                                class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border-2"
                                :class="activeImage === '{{ asset('storage/' . $img) }}' ? 'border-orange-500' : 'border-transparent'">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-center object-cover">
                        </button>
                        @endforeach
                    @endif
                </div>

                <!-- Description Below Gallery -->
                 <div class="mt-8 bg-white p-6 rounded-2xl shadow-sm">
                    <h3 class="font-bold text-gray-900 mb-4 text-lg border-b pb-2">تفاصيل المنتج</h3>
                    <div class="prose prose-orange text-gray-600 leading-7">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function productPage() {
    return {
        qty: 1,
        selectedModel: '',
        activeImage: '{{ asset('storage/' . $product->main_image) }}',
        formData: {
            nom: '',
            prenom: '',
            telephone: '',
            wilaya: '',
            commune: ''
        },
        loading: false,
        errors: {},
        formatPrice(price) {
            return new Intl.NumberFormat('fr-DZ').format(price);
        },
        submitOrder() {
            this.loading = true;
            this.errors = {};
            
            const phoneRegex = /^(05|06|07)[0-9]{8}$/;
            if (!phoneRegex.test(this.formData.telephone)) {
                this.errors.telephone = "رقم الهاتف غير صحيح (يرجى إدخال 05, 06, أو 07 متبوعاً بـ 8 أرقام)";
                this.loading = false;
                return;
            }

            @if($product->available_models)
            if (!this.selectedModel) {
                alert("يرجى اختيار الموديل / اللون");
                this.loading = false;
                return;
            }
            @endif

            const payload = {
                product_id: '{{ $product->id }}',
                product_slug: '{{ $product->slug }}',
                quantity: this.qty,
                selected_model: this.selectedModel,
                ...this.formData
            };

            fetch('{{ route("front.order.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert('خطأ غير متوقع. يرجى المحاولة مرة أخرى.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('خطأ في الاتصال. تحقق من الإنترنت.');
            })
            .finally(() => {
                this.loading = false;
            });
        }
    }
}
</script>
@endsection
