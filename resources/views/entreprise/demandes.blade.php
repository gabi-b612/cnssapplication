@extends('layouts.entreprise')

@section('title', 'Mes Demandes - CNSS')
@section('page-title', 'Mes Demandes')

@section('content')
<div class="mb-6 flex items-center justify-end">
    <a href="{{ route('entreprise.demandes.create') }}" class="px-5 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2 shadow-sm">
        <i class="fas fa-plus"></i>Nouvelle demande
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Réf.</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Travailleur</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Documents</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($demandes as $demande)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black-blue">
                            #{{ $demande->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $demande->travailleur->nom }} {{ $demande->travailleur->postnom }} {{ $demande->travailleur->prenom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ ucfirst($demande->type_allocation) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($demande->statut === 'en_attente')
                                <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                    <i class="fas fa-clock mr-1"></i>En attente
                                </span>
                            @elseif($demande->statut === 'validee')
                                <span class="inline-flex items-center px-3 py-1 bg-my-green/10 text-my-green rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Validée
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i>Rejetée
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            @if($demande->documents)
                                <span class="inline-flex items-center gap-1 text-my-green">
                                    <i class="fas fa-file-pdf"></i>{{ count($demande->documents) }} fichier(s)
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $demande->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-file-contract text-gray-300 text-3xl"></i>
                                <p class="text-gray-500 font-medium">Aucune demande soumise</p>
                                <a href="{{ route('entreprise.demandes.create') }}" class="text-my-green text-sm font-medium hover:underline">
                                    Soumettre une demande →
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($demandes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $demandes->links() }}
        </div>
    @endif
</div>
@endsection
