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
                <p class="text-gray-600 text-sm font-medium">En cours</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['demandes_en_cours'] }}</p>
            </div>
            <div class="bg-yellow-500/10 p-4 rounded-lg">
                <i class="fas fa-clock text-yellow-500 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-my-green">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Approuvées / Payées</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['demandes_approuvees'] }}</p>
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

@if($demandesEnCours->isNotEmpty())
<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-black-blue">Demandes en cours</h3>
        <a href="{{ route('entreprise.demandes.index') }}" class="text-my-green text-sm font-medium hover:underline">Voir tout →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Réf.</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Travailleur</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($demandesEnCours as $demande)
                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location='{{ route('entreprise.demandes.show', $demande) }}'">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-blue">#{{ $demande->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $demande->travailleur->nom }} {{ $demande->travailleur->postnom }} {{ $demande->travailleur->prenom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $demande->type_allocation)) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-demande-statut-badge :statut="$demande->statut" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $demande->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
