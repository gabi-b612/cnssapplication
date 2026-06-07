<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - CNSS Administration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-black-blue via-black-blue to-my-green/80 min-h-screen flex items-center justify-center font-sans antialiased p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">CNSS</h1>
            <p class="text-gray-300 text-sm">Caisse Nationale de Sécurité Sociale</p>
        </div>

        <div class="bg-white rounded-xl shadow-2xl p-8">
            <h2 class="text-2xl font-semibold text-black-blue mb-6">Connexion Administrateur</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 font-medium text-sm">Erreur d'authentification</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm mt-1">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green transition-all {{ $errors->has('email') ? 'border-red-500' : '' }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de Passe</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green transition-all {{ $errors->has('password') ? 'border-red-500' : '' }}">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-my-green rounded border-gray-300 focus:ring-my-green">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <button type="submit" class="w-full bg-my-green text-white font-medium py-2.5 rounded-lg hover:opacity-90 transition-opacity mt-2 shadow-sm">
                    Connecter
                </button>
            </form>
        </div>

        <div class="mt-8 text-center text-gray-300 text-xs">
            <p>&copy; {{ date('Y') }} CNSS — RDC. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
