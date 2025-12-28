<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen fixed inset-y-0 left-0 z-50">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold tracking-wider">E-Shop<span class="text-blue-500">Admin</span></h1>
            </div>
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition' }}">
                    <span>📊</span>
                    <span class="font-medium">Tableau de bord</span>
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition' }}">
                    <span>📦</span>
                    <span class="font-medium">Produits</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition' }}">
                    <span>🛒</span>
                    <span class="font-medium">Commandes</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition' }}">
                    <span>⚙️</span>
                    <span class="font-medium">Paramètres</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-800">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 text-gray-400 hover:text-red-400 transition w-full px-4 py-2">
                        <span>🚪</span>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
