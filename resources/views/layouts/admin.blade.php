<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CNSS - Administration')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="w-64 bg-black-blue text-white flex flex-col fixed h-screen">
            <!-- Logo -->
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold text-my-green">CNSS</h1>
                <p class="text-sm text-gray-400 mt-1">Administration</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-chart-line mr-2"></i>Dashboard
                </a>

                <a href="{{ route('admin.entreprises.index') }}"
                   class="block px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.entreprises.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-building mr-2"></i>Entreprises
                </a>

                <a href="{{ route('admin.administrateurs.index') }}"
                   class="block px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.administrateurs.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-users mr-2"></i>Administrateurs
                </a>

                <a href="{{ route('admin.liquidations.index') }}"
                   class="block px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.liquidations.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-money-bill-wave mr-2"></i>Liquidations
                </a>
            </nav>

            <!-- User Section -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium">{{ auth('administrateur')->user()->nom ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">Administrateur</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-my-green transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64 overflow-auto">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-black-blue">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center gap-4">

                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-8">
                <!-- Flash Messages -->
                @if ($message = session('success'))
                    <x-toast type="success" :message="$message" />
                @endif

                @if ($message = session('error'))
                    <x-toast type="error" :message="$message" />
                @endif

                <!-- Page Body -->
                @yield('content')
            </div>
        </div>
    </div>

    @stack('modals')
</body>
</html>
