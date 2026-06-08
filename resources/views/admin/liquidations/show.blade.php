@extends('layouts.admin')

@section('title', 'Détails Liquidation - Administration CNSS')
@section('page-title', 'Détails de la Liquidation')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.liquidations.historique') }}" class="text-my-green hover:underline flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations Principales -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <div class="mb-6 pb-6 border-b">
            <h2 class="text-2xl font-bold text-black-blue mb-2">#Liquidation {{ $liquidation->id }}</h2>
            <p class="text-gray-600">Créée le {{ $liquidation->created_at->format('d/m/Y à H:i') }}</p>
        </div>

        <!-- Section Demande -->
        <div class="border-b pb-6 mb-6">
            <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-file-contract text-my-green"></i>Demande Associée
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">ID Demande</p>
                    <p class="text-lg font-medium text-black-blue mt-1">#{{ $liquidation->demande->id }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Type d'Allocation</p>
                    <p class="text-lg font-medium text-my-green mt-1">{{ ucfirst(str_replace('_', ' ', $liquidation->demande->type_allocation)) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Statut Demande</p>
                    <p class="mt-1">
                        @php $statutDemande = $liquidation->demande->statut; @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $statutDemande === 'liquidee' ? 'bg-my-green/10 text-my-green' : 'bg-green-100 text-green-700' }}">
                            <i class="fas fa-check-circle mr-1"></i>{{ ucfirst(str_replace('_', ' ', $statutDemande)) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Section Travailleur -->
        <div class="border-b pb-6 mb-6">
            <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-user text-my-green"></i>Bénéficiaire
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Nom Complet</p>
                    <p class="text-lg font-medium text-black-blue mt-1">
                        {{ $liquidation->demande->travailleur->prenom }} {{ $liquidation->demande->travailleur->nom }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Email</p>
                    <p class="text-lg font-medium text-my-green break-all mt-1">{{ $liquidation->demande->travailleur->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Entreprise</p>
                    <p class="text-lg font-medium text-black-blue mt-1">{{ $liquidation->demande->entreprise->raison_sociale }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Date de Naissance</p>
                    <p class="text-lg font-medium text-black-blue mt-1">{{ $liquidation->demande->travailleur->date_naissance->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Section Montant -->
        <div class="border-b pb-6 mb-6">
            <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-money-bill-wave text-my-green"></i>Montant Liquidé
            </h3>
            <div class="p-6 bg-gradient-to-r from-my-green/10 to-my-green/5 rounded-lg border border-my-green/20">
                <div class="text-center">
                    <p class="text-gray-600 text-sm mb-2">Montant</p>
                    <p class="text-5xl font-bold text-my-green">{{ number_format($liquidation->montant, 2, ',', ' ') }} FC</p>
                    <p class="text-xs text-gray-500 mt-4">CDF — Franc congolais</p>
                </div>
            </div>
        </div>

        <!-- Section Dates -->
        <div class="border-b pb-6 mb-6">
            <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-calendar text-my-green"></i>Dates
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Date de Liquidation</p>
                    <p class="text-lg font-medium text-black-blue mt-2">{{ $liquidation->date_liquidation->format('d/m/Y') }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Créée le</p>
                    <p class="text-lg font-medium text-black-blue mt-2">{{ $liquidation->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Section Administrateur -->
        <div>
            <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-user-tie text-my-green"></i>Administrateur
            </h3>
            <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Créé par</p>
                <p class="text-lg font-medium text-black-blue mt-2">{{ $liquidation->administrateur->prenom }} {{ $liquidation->administrateur->nom }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $liquidation->administrateur->fonction }}</p>
            </div>
        </div>
    </div>

    <!-- Informations Additionnelles -->
    <div class="space-y-6">
        <!-- Statut -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <h3 class="text-sm font-bold text-green-600 uppercase tracking-wide mb-4">Statut</h3>
            <div class="text-center py-4">
                <div class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-full font-medium">
                    <i class="fas fa-check-circle mr-2"></i>Effectuée
                </div>
            </div>
        </div>

        <!-- Récapitulatif -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Récapitulatif</h3>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="text-gray-600">ID Liquidation</span>
                    <span class="font-medium text-black-blue">#{{ $liquidation->id }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="text-gray-600">ID Demande</span>
                    <span class="font-medium text-black-blue">#{{ $liquidation->demande->id }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="text-gray-600">Montant</span>
                    <span class="font-bold text-my-green">{{ number_format($liquidation->montant, 2, ',', ' ') }} FC</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="text-gray-600">Type</span>
                    <span class="font-medium text-black-blue">{{ ucfirst(str_replace('_', ' ', $liquidation->demande->type_allocation)) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
