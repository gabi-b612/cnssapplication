@extends('layouts.admin')

@section('title', 'Dashboard - Administration CNSS')
@section('page-title', 'Tableau de Bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card Entreprises -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-my-green">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Entreprises</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['entreprises'] ?? 0 }}</p>
            </div>
            <div class="bg-my-green/10 p-4 rounded-lg">
                <i class="fas fa-building text-my-green text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.entreprises.index') }}" class="text-my-green text-sm font-medium mt-4 inline-block hover:underline">
            Voir les détails →
        </a>
    </div>

    <!-- Card Administrateurs -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Administrateurs</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['administrateurs'] ?? 0 }}</p>
            </div>
            <div class="bg-blue-500/10 p-4 rounded-lg">
                <i class="fas fa-users text-blue-500 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card Liquidations -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Liquidations</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['liquidations'] ?? 0 }}</p>
            </div>
            <div class="bg-yellow-500/10 p-4 rounded-lg">
                <i class="fas fa-money-bill-wave text-yellow-500 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card Demandes -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Demandes</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['demandes'] ?? 0 }}</p>
            </div>
            <div class="bg-purple-500/10 p-4 rounded-lg">
                <i class="fas fa-file-contract text-purple-500 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-black-blue mb-4">Activités Récentes</h3>
        <div class="space-y-3">
            <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                <div class="w-10 h-10 bg-my-green/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-plus text-my-green"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-blue">Nouvelle entreprise créée</p>
                    <p class="text-xs text-gray-500">Il y a 2 heures</p>
                </div>
            </div>
            <div class="flex items-center gap-3 pb-3 border-b border-gray-200">
                <div class="w-10 h-10 bg-blue-500/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-blue-500"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-blue">Demande validée</p>
                    <p class="text-xs text-gray-500">Il y a 5 heures</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-500/10 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill text-yellow-500"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-blue">Liquidation effectuée</p>
                    <p class="text-xs text-gray-500">Il y a 1 jour</p>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-black-blue mb-4">État du Système</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Base de données</span>
                <span class="inline-block px-3 py-1 bg-my-green/10 text-my-green text-xs font-semibold rounded-full">
                    <i class="fas fa-check-circle mr-1"></i>Actif
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Authentification</span>
                <span class="inline-block px-3 py-1 bg-my-green/10 text-my-green text-xs font-semibold rounded-full">
                    <i class="fas fa-check-circle mr-1"></i>Actif
                </span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Sessions</span>
                <span class="inline-block px-3 py-1 bg-my-green/10 text-my-green text-xs font-semibold rounded-full">
                    <i class="fas fa-check-circle mr-1"></i>Actif
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
