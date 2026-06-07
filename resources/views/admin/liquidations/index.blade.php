@extends('layouts.admin')

@section('title', 'Liquidations - Administration CNSS')
@section('page-title', 'Gestion des Liquidations')

@section('content')
<div class="mb-6 flex items-center justify-end">
    <x-modal
        id="modal-liquidation"
        title="Ajouter une Liquidation"
        submit-text="Créer"
        form-id="modal-form-liquidation"
        :open-on-load="$errors->any()"
    >
        <x-slot:trigger>
            <button type="button" class="px-5 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2 shadow-sm">
                <i class="fas fa-plus"></i>Ajouter une liquidation
            </button>
        </x-slot:trigger>

        <form action="{{ route('admin.liquidations.store') }}" method="POST" id="modal-form-liquidation" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Demande *</label>
                <select name="demande_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('demande_id') ? 'border-red-500' : '' }}">
                    <option value="">Sélectionnez une demande</option>
                    @foreach($demandes as $demande)
                        <option value="{{ $demande->id }}" @selected(old('demande_id') == $demande->id)>
                            #{{ $demande->id }} — {{ $demande->travailleur->prenom }} {{ $demande->travailleur->nom }}
                        </option>
                    @endforeach
                </select>
                @error('demande_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Montant (USD) *</label>
                <input type="number" name="montant" step="0.01" min="0.01" value="{{ old('montant') }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('montant') ? 'border-red-500' : '' }}">
                @error('montant')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de Liquidation *</label>
                <input type="date" name="date_liquidation" value="{{ old('date_liquidation', now()->format('Y-m-d')) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('date_liquidation') ? 'border-red-500' : '' }}">
                @error('date_liquidation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </form>
    </x-modal>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        ID Demande
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Travailleur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Montant (USD)
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Date Liquidation
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Administrateur
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Statut
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
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
                            <a href="{{ route('admin.liquidations.show', $liquidation) }}" class="text-my-green hover:text-black-blue transition-colors mr-3" title="Voir les détails">
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
                                <i class="fas fa-money-bill-wave text-gray-300 text-3xl"></i>
                                <p class="text-gray-500 font-medium">Aucune liquidation enregistrée</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($liquidations->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $liquidations->links() }}
        </div>
    @endif
</div>
@endsection
