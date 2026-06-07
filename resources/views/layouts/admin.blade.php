<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CNSS - Gestionnaire RH')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-black-blue text-white flex flex-col fixed h-screen shadow-xl z-20">
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold text-my-green tracking-tight">CNSS</h1>
                <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">Gestionnaire RH</p>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-chart-line w-5 mr-3"></i>Dashboard
                </a>

                <a href="{{ route('admin.entreprises.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('admin.entreprises.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-building w-5 mr-3"></i>Entreprises
                </a>

                <a href="{{ route('admin.travailleurs.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('admin.travailleurs.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-users w-5 mr-3"></i>Travailleurs
                </a>

                <a href="{{ route('admin.demandes-validees.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('admin.demandes-validees.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-file-contract w-5 mr-3"></i>Demandes validées
                </a>

                <a href="{{ route('admin.liquidations.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('admin.liquidations.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-money-bill-wave w-5 mr-3"></i>Liquidations
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth('administrateur')->user()->nom ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">Gestionnaire RH</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline shrink-0">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-my-green transition-colors p-2" title="Déconnexion">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64 overflow-auto">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
                <div class="px-8 py-5">
                    <h2 class="text-2xl font-semibold text-black-blue">@yield('page-title', 'Dashboard')</h2>
                </div>
            </header>

            <main class="p-8">
                @if ($message = session('success'))
                    <x-toast type="success" :message="$message" />
                @endif

                @if ($message = session('error'))
                    <x-toast type="error" :message="$message" />
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('modals')
</body>
</html>
