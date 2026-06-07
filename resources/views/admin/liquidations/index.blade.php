@extends('layouts.admin')

@section('title', 'Liquidations - Gestionnaire RH CNSS')
@section('page-title', 'Liquider les Demandes Validées')

@section('content')
<div class="mb-6">
    <p class="text-gray-600 text-sm">
        Sélectionnez une demande validée et cliquez sur <strong>Liquider</strong> pour enregistrer le montant versé au bénéficiaire.
    </p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Travailleur</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Entreprise</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date validation</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($demandes as $demande)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-black-blue">#{{ $demande->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $demande->travailleur?->prenom }} {{ $demande->travailleur?->nom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $demande->entreprise?->raison_sociale ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                                {{ ucfirst(str_replace('_', ' ', $demande->type_allocation)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $demande->updated_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <x-modal
                                id="modal-liquidation-{{ $demande->id }}"
                                title="Liquider la demande #{{ $demande->id }}"
                                submit-text="Confirmer la liquidation"
                                :form-id="'modal-form-liquidation-' . $demande->id"
                                :open-on-load="$errors->any() && old('demande_id') == $demande->id"
                            >
                                <x-slot:trigger>
                                    <button type="button" class="px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2 ml-auto">
                                        <i class="fas fa-money-bill-wave"></i>Liquider
                                    </button>
                                </x-slot:trigger>

                                <form action="{{ route('admin.liquidations.store') }}" method="POST" id="modal-form-liquidation-{{ $demande->id }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="demande_id" value="{{ $demande->id }}">

                                    @if($errors->any() && old('demande_id') == $demande->id)
                                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <p><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="p-4 bg-gray-50 rounded-lg text-sm space-y-2">
                                        <p><span class="text-gray-600">Bénéficiaire :</span> <strong>{{ $demande->travailleur?->prenom }} {{ $demande->travailleur?->nom }}</strong></p>
                                        <p><span class="text-gray-600">Type :</span> <strong>{{ ucfirst(str_replace('_', ' ', $demande->type_allocation)) }}</strong></p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant (CDF) *</label>
                                        <input type="number" name="montant" step="0.01" min="0.01" value="{{ old('demande_id') == $demande->id ? old('montant') : '' }}" required
                                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('montant') && old('demande_id') == $demande->id ? 'border-red-500' : '' }}">
                                        @if($errors->has('montant') && old('demande_id') == $demande->id)
                                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('montant') }}</p>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de liquidation *</label>
                                        <input type="date" name="date_liquidation" value="{{ old('demande_id') == $demande->id ? old('date_liquidation') : now()->format('Y-m-d') }}" required
                                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('date_liquidation') && old('demande_id') == $demande->id ? 'border-red-500' : '' }}">
                                        @if($errors->has('date_liquidation') && old('demande_id') == $demande->id)
                                            <p class="text-red-500 text-xs mt-1">{{ $errors->first('date_liquidation') }}</p>
                                        @endif
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-check-circle text-gray-300 text-3xl"></i>
                                <p class="text-gray-500 font-medium">Aucune donnée disponible</p>
                                <p class="text-gray-400 text-sm">Toutes les demandes validées ont été liquidées.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.liquidations.historique') }}" class="text-my-green hover:underline text-sm font-medium flex items-center gap-2">
        <i class="fas fa-history"></i>Voir l'historique des liquidations
    </a>
</div>
@endsection
