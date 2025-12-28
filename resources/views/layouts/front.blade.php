<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::where('key', 'site_name')->value('value') ?? 'Matjari' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        .font-main { font-family: 'Cairo', sans-serif; }
    </style>
    
    <!-- Facebook Pixel Code -->
    @php
        $pixelId = \App\Models\Setting::where('key', 'facebook_pixel_id')->value('value');
    @endphp
    @if($pixelId)
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $pixelId }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $pixelId }}&ev=PageView&noscript=1"
    /></noscript>
    @endif
    <!-- End Facebook Pixel Code -->

    @stack('head')
</head>
<body class="font-main bg-gray-50 text-gray-900 antialiased flex flex-col min-h-screen">

    <!-- Top Bar -->
    <div class="bg-orange-500 text-white text-center py-2 text-sm font-bold">
        التوصيل لباب المنزل و الدفع عند الاستلام المنتح
    </div>

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <h1 class="text-3xl font-black text-gray-900 tracking-tighter">MATJARI <span class="text-orange-500">DZ</span></h1>
            </a>

             <!-- Search / Cart (Mock) -->
            <div class="hidden sm:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-orange-500 font-medium">الرئيسية</a>
                <a href="#footer" class="text-gray-600 hover:text-orange-500 font-medium">اتصل بنا</a>
            </div>

             <div class="flex items-center gap-4">
                 <!-- Cart Removed as per request -->
                 <a href="#footer" class="flex items-center gap-1 bg-gray-100 px-4 py-2 rounded-full text-sm font-bold text-gray-800 hover:bg-orange-100 transition">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>اتصل بنا</span>
                 </a>
             </div>
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="bg-white border-t mt-12 py-12">
        <div class="max-w-7xl mx-auto px-4 flex flex-col items-center justify-center text-center">
            <h2 class="text-2xl font-black text-gray-900 mb-4">MATJARI <span class="text-orange-500">DZ</span></h2>
            <p class="text-gray-500 mb-8 max-w-md">متجرك المفضل للتسوق عبر الإنترنت في الجزائر. أفضل المنتجات بأفضل الأسعار مع توصيل سريع.</p>
            
            <div class="flex gap-4 text-sm text-gray-600 font-medium">
                <a href="#" class="hover:text-orange-500">من نحن</a>
                <a href="#" class="hover:text-orange-500">سياسة الخصوصية</a>
                <a href="#" class="hover:text-orange-500">شروط الاستخدام</a>
            </div>

            <p class="mt-8 text-xs text-gray-400">&copy; {{ date('Y') }} Matjari DZ. Tous droits réservés.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
