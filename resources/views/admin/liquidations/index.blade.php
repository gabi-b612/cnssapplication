@extends('layouts.admin')

@section('title', 'Liquidations - Administration CNSS')
@section('page-title', 'Gestion des Liquidations')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-gray-600">Gérez les liquidations des prestations aux familles.</p>
    <button @click="$refs.modalLiquidation.open = true" class="px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2">
        <i class="fas fa-plus"></i>Ajouter une liquidation
    </button>
</div>

<!-- Tableau des Liquidations -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        ID Demande
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Travailleur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Montant (USD)
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Date Liquidation
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Administrateur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Statut
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($liquidations as $liquidation)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-black-blue">#{{ $liquidation->demande_id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $liquidation->demande->travailleur->prenom }} {{ $liquidation->demande->travailleur->nom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-my-green">${{ number_format($liquidation->montant, 2, '.', ',') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $liquidation->date_liquidation->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $liquidation->administrateur->nom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block px-3 py-1 bg-my-green/10 text-my-green rounded-full text-xs font-medium">
                                <i class="fas fa-check-circle mr-1"></i>Effectuée
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.liquidations.show', $liquidation) }}" class="text-blue-600 hover:text-blue-900 transition-colors mr-3" title="Voir les détails">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.liquidations.destroy', $liquidation) }}" 
                                  class="inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette liquidation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                                <p class="text-gray-500 font-medium">Aucune liquidation trouvée</p>
                                <p class="text-sm text-gray-400">Créez une nouvelle liquidation pour commencer.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($liquidations->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $liquidations->links() }}
        </div>
    @endif
</div>

<!-- Modal Ajouter Liquidation -->
<div x-data="{ open: false }" @keydown.escape="open = false" x-ref="modalLiquidation" class="relative">
    <!-- Modal Backdrop -->
    <div x-show="open" @click="open = false" x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-40"></div>

    <!-- Modal -->
    <div x-show="open" @click.away="open = false" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95" 
         class="fixed inset-0 flex items-center justify-center z-50 p-4">
        
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-screen overflow-y-auto">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-bold text-black-blue">Ajouter une Liquidation</h3>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Body -->
            <form action="{{ route('admin.liquidations.store') }}" method="POST" id="modal-form-liquidation" class="p-6 space-y-4">
                @csrf

                <!-- Demande -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Demande (en attente de liquidation) *</label>
                    <select name="demande_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('demande_id') ? 'border-red-500' : '' }}">
                        <option value="">Sélectionnez une demande</option>
                        @foreach($demandes as $demande)
                            <option value="{{ $demande->id }}">
                                #{{ $demande->id }} - {{ $demande->travailleur->prenom }} {{ $demande->travailleur->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('demande_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Montant -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant (USD) *</label>
                    <input type="number" name="montant" step="0.01" min="0.01" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('montant') ? 'border-red-500' : '' }}"
                           placeholder="0.00">
                    @error('montant')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Note: Basé sur 6.5% des cotisations familiales</p>
                </div>

                <!-- Date Liquidation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de Liquidation *</label>
                    <input type="date" name="date_liquidation" value="{{ now()->format('Y-m-d') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('date_liquidation') ? 'border-red-500' : '' }}">
                    @error('date_liquidation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Note -->
                <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-xs text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        La liquidation sera enregistrée sous votre nom et sera immuable.
                    </p>
                </div>
            </form>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex gap-3 sticky bottom-0">
                <button @click="open = false" type="button" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                    Annuler
                </button>
                <button form="modal-form-liquidation" type="submit" 
                        class="flex-1 px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                    Créer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
