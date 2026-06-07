<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-black-blue via-gray-900 to-my-green/20 min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-500/20 rounded-full mb-6">
            <i class="fas fa-exclamation-triangle text-red-400 text-4xl"></i>
        </div>

        <h1 class="text-6xl font-bold text-white mb-2">404</h1>
        <p class="text-xl text-gray-300 mb-6">Page non trouvée</p>
        
        <p class="text-gray-400 mb-8 max-w-md">
            Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
        </p>

        <div class="flex gap-4 justify-center flex-wrap">
            <a href="/" class="px-6 py-3 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2">
                <i class="fas fa-home"></i>Retour à l'accueil
            </a>
            <a href="javascript:history.back()" class="px-6 py-3 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-colors font-medium flex items-center gap-2 border border-white/20">
                <i class="fas fa-arrow-left"></i>Retour précédent
            </a>
        </div>
    </div>
</body>
</html>
