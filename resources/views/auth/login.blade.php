<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - CNSS Administration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-black-blue to-my-green min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">CNSS</h1>
            <p class="text-gray-300">Système de Gestion des Prestations</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-black-blue mb-2">Connexion Administrateur</h2>
            <p class="text-gray-600 text-sm mb-6">Accédez à votre portail d'administration</p>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 font-medium">Erreur d'authentification</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green transition-all {{ $errors->has('email') ? 'border-red-500 ring-red-500' : '' }}"
                           placeholder="votre@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de Passe</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green transition-all {{ $errors->has('password') ? 'border-red-500 ring-red-500' : '' }}"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-my-green">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-my-green text-white font-medium py-2 rounded-lg hover:opacity-90 transition-opacity mt-6">
                    Connecter
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 pt-6 border-t border-gray-200 text-center text-sm text-gray-600">
                <p>Besoin d'assistance ? <a href="mailto:support@cnss.cd" class="text-my-green font-medium hover:underline">Contactez le support</a></p>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center text-gray-300 text-sm">
            <p>&copy; 2024 CNSS - RDC. Tous les droits réservés.</p>
        </div>
    </div>
</body>
</html>
