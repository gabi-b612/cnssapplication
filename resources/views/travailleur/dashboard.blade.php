@extends('layouts.travailleur')

@section('title', 'Tableau de bord - Espace Travailleur CNSS')
@section('page-title', 'Tableau de bord')

@section('content')
{{-- Section profil --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
    <h3 class="text-lg font-semibold text-black-blue mb-4 flex items-center gap-2">
        <i class="fas fa-user text-my-green"></i>Mon Profil
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Nom complet</p>
            <p class="text-black-blue font-medium mt-1">{{ $travailleur->nom }} {{ $travailleur->postnom }} {{ $travailleur->prenom }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Email</p>
            <p class="text-black-blue font-medium mt-1 break-all">{{ $travailleur->email }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Téléphone</p>
            <p class="text-black-blue font-medium mt-1">{{ $travailleur->telephone ?? '—' }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Date de naissance</p>
            <p class="text-black-blue font-medium mt-1">{{ $travailleur->date_naissance->format('d/m/Y') }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Sexe</p>
            <p class="text-black-blue font-medium mt-1">{{ $travailleur->sexe === 'M' ? 'Masculin' : 'Féminin' }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Entreprise</p>
            <p class="text-black-blue font-medium mt-1">{{ $travailleur->entreprise?->raison_sociale ?? '—' }}</p>
        </div>
    </div>
</div>

{{-- Section Mes Demandes --}}
<div id="mes-demandes" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-black-blue flex items-center gap-2">
            <i class="fas fa-file-contract text-my-green"></i>Mes Demandes
        </h3>
        <p class="text-sm text-gray-500 mt-1">Suivez l'évolution de vos demandes d'allocations soumises par votre entreprise.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($demandes as $demande)
                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="window.location='{{ route('travailleur.demandes.show', $demande) }}'">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ ucfirst(str_replace('_', ' ', $demande->type_allocation)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $demande->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-demande-statut-badge :statut="$demande->statut" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <a href="{{ route('travailleur.demandes.show', $demande) }}"
                               class="text-my-green hover:underline font-medium"
                               onclick="event.stopPropagation()">
                                Consulter →
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-inbox text-gray-300 text-3xl"></i>
                                <p class="text-gray-500 font-medium">Aucune demande enregistrée pour le moment</p>
                                <p class="text-gray-400 text-sm">Votre entreprise n'a pas encore soumis de demande d'allocation en votre nom.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
