@extends('layouts.admin')

@section('title', 'Rapports statistiques - CNSS')
@section('page-title', 'Rapports statistiques')

@section('content')
<form method="GET" action="{{ route('admin.rapports.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Date début</label>
        <input type="date" name="date_debut" value="{{ $dateDebut }}"
               class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Date fin</label>
        <input type="date" name="date_fin" value="{{ $dateFin }}"
               class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
    </div>
    <button type="submit" class="px-4 py-2 bg-my-green text-white rounded-lg text-sm font-medium hover:opacity-90">
        <i class="fas fa-filter mr-1"></i>Filtrer
    </button>
    <a href="{{ route('admin.rapports.export', ['date_debut' => $dateDebut, 'date_fin' => $dateFin]) }}"
       class="px-4 py-2 border border-my-green text-my-green rounded-lg text-sm font-medium hover:bg-my-green/5">
        <i class="fas fa-download mr-1"></i>Exporter CSV
    </a>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <p class="text-sm text-gray-600">Total demandes</p>
        <p class="text-3xl font-bold text-black-blue mt-1">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <p class="text-sm text-gray-600">Montant liquidé</p>
        <p class="text-2xl font-bold text-my-green mt-1">{{ number_format($stats['montant_liquide'], 0, ',', ' ') }} FC</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <p class="text-sm text-gray-600">Taux d'approbation</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['taux_approbation'] }}%</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <p class="text-sm text-gray-600">Taux de rejet</p>
        <p class="text-3xl font-bold text-red-600 mt-1">{{ $stats['taux_rejet'] }}%</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-black-blue mb-4">Demandes par statut</h3>
        <div class="space-y-2">
            @forelse($stats['par_statut'] as $statut => $total)
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                    <x-demande-statut-badge :statut="$statut" />
                    <span class="font-bold text-black-blue">{{ $total }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Aucune donnée</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-black-blue mb-4">Demandes par type</h3>
        <div class="space-y-2">
            @forelse($stats['par_type'] as $type => $total)
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                    <span class="font-bold text-black-blue">{{ $total }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Aucune donnée</p>
            @endforelse
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-black-blue mb-4">Top 5 entreprises</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-4 py-2 text-left text-gray-600">Entreprise</th>
                    <th class="px-4 py-2 text-right text-gray-600">Demandes</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($topEntreprises as $ligne)
                    <tr>
                        <td class="px-4 py-2">{{ $ligne->entreprise?->raison_sociale ?? '—' }}</td>
                        <td class="px-4 py-2 text-right font-bold">{{ $ligne->total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-8 text-center text-gray-500">Aucune donnée</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
