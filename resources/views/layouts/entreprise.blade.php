<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CNSS - Espace Entreprise')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-black-blue text-white flex flex-col fixed h-screen shadow-xl z-20">
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold text-my-green tracking-tight">CNSS</h1>
                <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">Espace Entreprise</p>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('entreprise.dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('entreprise.dashboard') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-chart-line w-5 mr-3"></i>Dashboard
                </a>

                <a href="{{ route('entreprise.travailleurs.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('entreprise.travailleurs.*') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-users w-5 mr-3"></i>Mes Travailleurs
                </a>

                <a href="{{ route('entreprise.demandes.index') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('entreprise.demandes.index') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-file-contract w-5 mr-3"></i>Mes Demandes
                </a>

                <a href="{{ route('entreprise.demandes.create') }}"
                   class="flex items-center px-4 py-3 rounded-lg transition-colors text-sm font-medium {{ request()->routeIs('entreprise.demandes.create') ? 'bg-my-green text-black-blue' : 'text-white hover:bg-white/10' }}">
                    <i class="fas fa-plus-circle w-5 mr-3"></i>Nouvelle Demande
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate">{{ auth('entreprise')->user()->raison_sociale }}</p>
                        <p class="text-xs text-gray-400">Employeur</p>
                    </div>
                    <form action="{{ route('entreprise.logout') }}" method="POST" class="inline shrink-0">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-my-green transition-colors p-2" title="Déconnexion">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

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
