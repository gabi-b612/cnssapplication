@extends('layouts.admin')

@section('title', 'Configuration - Administration CNSS')
@section('page-title', 'Paramètres de Calcul')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <p class="text-gray-600 text-sm mb-6">
            Définissez le taux de cotisation et les montants fixes des allocations CNSS (en francs congolais).
        </p>

        <form action="{{ route('admin.configuration.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Taux de cotisation (%) *</label>
                <input type="number" name="taux_cotisation" step="0.01" min="0" max="100"
                       value="{{ old('taux_cotisation', $configuration->taux_cotisation) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('taux_cotisation') ? 'border-red-500' : '' }}">
                @error('taux_cotisation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Exemple : 6,5 pour 6,5 % du salaire brut.</p>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-semibold text-black-blue uppercase tracking-wide mb-4">Montants d'allocation (FC)</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Allocation familiale *</label>
                        <input type="number" name="montant_allocation_familiale" step="1" min="1"
                               value="{{ old('montant_allocation_familiale', (int) $configuration->montant_allocation_familiale) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('montant_allocation_familiale') ? 'border-red-500' : '' }}">
                        @error('montant_allocation_familiale')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Allocation maternité *</label>
                        <input type="number" name="montant_allocation_maternite" step="1" min="1"
                               value="{{ old('montant_allocation_maternite', (int) $configuration->montant_allocation_maternite) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('montant_allocation_maternite') ? 'border-red-500' : '' }}">
                        @error('montant_allocation_maternite')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Allocation prénatale *</label>
                        <input type="number" name="montant_allocation_prenatale" step="1" min="1"
                               value="{{ old('montant_allocation_prenatale', (int) $configuration->montant_allocation_prenatale) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('montant_allocation_prenatale') ? 'border-red-500' : '' }}">
                        @error('montant_allocation_prenatale')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-6 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2">
                    <i class="fas fa-save"></i>Enregistrer les paramètres
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
