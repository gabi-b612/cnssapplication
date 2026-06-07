@extends('layouts.apf')

@section('title', 'Demandes à traiter - CNSS APF')
@section('page-title', 'Demandes à traiter')

@section('content')
<div
    x-data="{
        open: false,
        demandeId: null,
        demandeRef: '',
        travailleur: '',
        entreprise: '',
        typeAllocation: '',
        openModal(demande) {
            this.demandeId = demande.id;
            this.demandeRef = '#' + demande.id;
            this.travailleur = demande.travailleur;
            this.entreprise = demande.entreprise;
            this.typeAllocation = demande.type;
            this.open = true;
        }
    }"
    @keydown.escape.window="open = false"
>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Réf.</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Travailleur</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Entreprise</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Documents</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
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
                                {{ $demande->entreprise->raison_sociale }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ ucfirst($demande->type_allocation) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($demande->documents)
                                    <div class="flex flex-col gap-1">
                                        @foreach($demande->documents as $document)
                                            <a href="{{ asset('storage/' . $document) }}" target="_blank"
                                               class="text-my-green hover:underline text-xs inline-flex items-center gap-1">
                                                <i class="fas fa-file-pdf"></i>PDF
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $demande->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button
                                    type="button"
                                    @click="openModal(@js([
                                        'id' => $demande->id,
                                        'travailleur' => $demande->travailleur->nom . ' ' . $demande->travailleur->postnom . ' ' . $demande->travailleur->prenom,
                                        'entreprise' => $demande->entreprise->raison_sociale,
                                        'type' => ucfirst($demande->type_allocation),
                                    ]))"
                                    class="px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity text-sm font-medium"
                                >
                                    <i class="fas fa-gavel mr-1"></i>Traiter
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <i class="fas fa-check-circle text-my-green text-3xl"></i>
                                    <p class="text-gray-500 font-medium">Aucune demande en attente</p>
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

    {{-- Modal de traitement --}}
    <div x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div
            class="fixed inset-0 bg-black/50 transition-opacity"
            @click="open = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative bg-white rounded-xl shadow-2xl max-w-md w-full"
                @click.stop
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-black-blue">
                        Traiter la demande <span x-text="demandeRef"></span>
                    </h3>
                    <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="p-6 space-y-3 text-sm text-gray-600">
                    <p><span class="font-medium text-black-blue">Travailleur :</span> <span x-text="travailleur"></span></p>
                    <p><span class="font-medium text-black-blue">Entreprise :</span> <span x-text="entreprise"></span></p>
                    <p><span class="font-medium text-black-blue">Type :</span> <span x-text="typeAllocation"></span></p>
                    <p class="text-xs text-gray-500 pt-2">Choisissez une action pour cette demande :</p>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex gap-3">
                    <button type="button" @click="open = false"
                            class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                        Annuler
                    </button>

                    <form :action="`{{ url('apf/demandes') }}/${demandeId}/valider`" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="statut" value="rejetee">
                        <button type="submit"
                                class="w-full px-4 py-2.5 bg-red-500 text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                            <i class="fas fa-times-circle mr-1"></i>Rejeter
                        </button>
                    </form>

                    <form :action="`{{ url('apf/demandes') }}/${demandeId}/valider`" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="statut" value="validee">
                        <button type="submit"
                                class="w-full px-4 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Valider
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
