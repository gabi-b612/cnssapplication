<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CNSS - Authentification')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-black-blue via-gray-900 to-my-green/20 min-h-screen flex items-center justify-center">
    <!-- Toast Messages -->
    @if($errors->any())
        <x-toast type="error" message="Erreurs de validation" />
    @endif
    @if(session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif

    <!-- Container -->
    <div class="w-full max-w-md mx-auto px-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="fixed bottom-4 left-0 right-0 text-center text-gray-400 text-xs">
        <p>&copy; {{ date('Y') }} CNSS-RDC. Tous droits réservés.</p>
    </footer>
</body>
</html>
