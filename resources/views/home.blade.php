<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNSS — Caisse Nationale de Sécurité Sociale</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-black-blue via-gray-900 to-my-green/30 min-h-screen font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="px-6 py-8 text-center">
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('img/logo-CNSS.png') }}" alt="Logo CNSS" class="h-24 md:h-32 mx-auto object-contain">
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-white mt-6 tracking-tight">Caisse Nationale de Sécurité Sociale</h1>
            <p class="text-gray-300 mt-2 max-w-xl mx-auto text-sm md:text-base">
                Plateforme de gestion des demandes d'allocations familiales, de maternité et prénatales.
            </p>
        </header>

        <main class="flex-1 flex items-center justify-center px-4 pb-16">
            <div class="w-full max-w-4xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <a href="{{ route('entreprise.login') }}"
                   class="group bg-white/95 backdrop-blur rounded-xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-lg bg-my-green/10 flex items-center justify-center mb-4 group-hover:bg-my-green/20 transition-colors">
                        <i class="fas fa-building text-my-green text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-black-blue">Espace Employeur</h2>
                    <p class="text-sm text-gray-600 mt-2">Soumettre et suivre les demandes pour vos travailleurs.</p>
                    <span class="inline-flex items-center gap-1 text-my-green text-sm font-medium mt-4 group-hover:underline">
                        Accéder <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                </a>

                <a href="{{ route('travailleur.login') }}"
                   class="group bg-white/95 backdrop-blur rounded-xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-lg bg-blue-500/10 flex items-center justify-center mb-4 group-hover:bg-blue-500/20 transition-colors">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-black-blue">Espace Travailleur</h2>
                    <p class="text-sm text-gray-600 mt-2">Consulter le statut de vos demandes d'allocations.</p>
                    <span class="inline-flex items-center gap-1 text-my-green text-sm font-medium mt-4 group-hover:underline">
                        Accéder <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                </a>

                <a href="{{ route('apf.login') }}"
                   class="group bg-white/95 backdrop-blur rounded-xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-lg bg-purple-500/10 flex items-center justify-center mb-4 group-hover:bg-purple-500/20 transition-colors">
                        <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-black-blue">Espace APF</h2>
                    <p class="text-sm text-gray-600 mt-2">Traiter et valider les dossiers soumis.</p>
                    <span class="inline-flex items-center gap-1 text-my-green text-sm font-medium mt-4 group-hover:underline">
                        Accéder <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                </a>

                <a href="{{ route('login') }}"
                   class="group bg-white/95 backdrop-blur rounded-xl shadow-lg border border-white/20 p-6 hover:shadow-xl hover:-translate-y-1 transition-all">
                    <div class="w-12 h-12 rounded-lg bg-yellow-500/10 flex items-center justify-center mb-4 group-hover:bg-yellow-500/20 transition-colors">
                        <i class="fas fa-user-tie text-yellow-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-black-blue">Administration</h2>
                    <p class="text-sm text-gray-600 mt-2">Gestion RH, liquidations et paramètres.</p>
                    <span class="inline-flex items-center gap-1 text-my-green text-sm font-medium mt-4 group-hover:underline">
                        Accéder <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                </a>
            </div>
        </main>

        <footer class="py-6 text-center text-gray-400 text-xs">
            <p>&copy; {{ date('Y') }} CNSS — RDC. Tous droits réservés.</p>
        </footer>
    </div>
</body>
</html>
