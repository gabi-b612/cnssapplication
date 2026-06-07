<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion APF - CNSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-black-blue via-black-blue to-my-green/80 min-h-screen flex items-center justify-center font-sans antialiased p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">CNSS</h1>
            <p class="text-gray-300 text-sm">Agent des Prestations aux Familles</p>
        </div>

        <div class="bg-white rounded-xl shadow-2xl p-8">
            <h2 class="text-2xl font-semibold text-black-blue mb-6">Connexion APF</h2>

            @if (session('success'))
                <div class="mb-4 p-4 bg-my-green/10 border border-my-green/30 rounded-lg">
                    <p class="text-my-green text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 font-medium text-sm">Erreur d'authentification</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm mt-1">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('apf.login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de Passe</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green transition-all">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-my-green rounded border-gray-300 focus:ring-my-green">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <button type="submit" class="w-full bg-my-green text-white font-medium py-2.5 rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                    Connecter
                </button>
            </form>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-gray-300 text-sm hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> Espace Administrateur
            </a>
        </div>
    </div>
</body>
</html>
