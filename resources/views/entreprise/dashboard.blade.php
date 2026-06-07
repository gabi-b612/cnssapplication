@extends('layouts.entreprise')

@section('title', 'Dashboard - Espace Entreprise CNSS')
@section('page-title', 'Tableau de Bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-my-green">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Travailleurs</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['travailleurs'] }}</p>
            </div>
            <div class="bg-my-green/10 p-4 rounded-lg">
                <i class="fas fa-users text-my-green text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('entreprise.travailleurs.index') }}" class="text-my-green text-sm font-medium mt-4 inline-block hover:underline">
            Gérer →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">En attente</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['demandes_en_attente'] }}</p>
            </div>
            <div class="bg-yellow-500/10 p-4 rounded-lg">
                <i class="fas fa-clock text-yellow-500 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-my-green">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Validées</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['demandes_validees'] }}</p>
            </div>
            <div class="bg-my-green/10 p-4 rounded-lg">
                <i class="fas fa-check-circle text-my-green text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Rejetées</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['demandes_rejetees'] }}</p>
            </div>
            <div class="bg-red-500/10 p-4 rounded-lg">
                <i class="fas fa-times-circle text-red-500 text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('entreprise.demandes.index') }}" class="text-my-green text-sm font-medium mt-4 inline-block hover:underline">
            Voir les demandes →
        </a>
    </div>
</div>

<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-black-blue mb-2">{{ $entreprise->raison_sociale }}</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
        <p><i class="fas fa-envelope text-my-green mr-2"></i>{{ $entreprise->email }}</p>
        <p><i class="fas fa-phone text-my-green mr-2"></i>{{ $entreprise->telephone ?? '—' }}</p>
        <p><i class="fas fa-map-marker-alt text-my-green mr-2"></i>{{ $entreprise->siege_social }}</p>
    </div>
</div>
@endsection
