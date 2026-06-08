@extends('layouts.admin')

@section('title', 'Détails Administrateur - Administration CNSS')
@section('page-title', 'Détails de l\'Administrateur')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.administrateurs.index') }}" class="text-my-green hover:underline flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations Principales -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-black-blue">{{ $administrateur->nom }} {{ $administrateur->postnom }}</h2>
                <p class="text-gray-600 text-sm mt-1">#{{ $administrateur->id }} • {{ $administrateur->fonction }}</p>
            </div>
            <a href="{{ route('admin.administrateurs.edit', $administrateur) }}" class="px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2">
                <i class="fas fa-edit"></i>Éditer
            </a>
        </div>

        <div class="border-b pb-6 mb-6">
            <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-user text-my-green"></i>Informations Personnelles
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Prénom</p>
                    <p class="text-lg font-medium text-gray-800 mt-1">{{ $administrateur->prenom }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Nom de Famille</p>
                    <p class="text-lg font-medium text-gray-800 mt-1">{{ $administrateur->nom }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Post-nom</p>
                    <p class="text-lg font-medium text-gray-800 mt-1">{{ $administrateur->postnom ?? 'Non fourni' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Fonction</p>
                    <p class="text-lg font-medium text-my-green mt-1">{{ $administrateur->fonction }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Email</p>
                    <p class="text-lg font-medium text-my-green break-all mt-1">{{ $administrateur->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Téléphone</p>
                    <p class="text-lg font-medium text-gray-800 mt-1">{{ $administrateur->telephone ?? 'Non fourni' }}</p>
                </div>
            </div>
        </div>

        <!-- Liquidations Créées -->
        <div>
            <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-file-invoice-dollar text-my-green"></i>Liquidations ({{ $liquidations->count() }})
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">ID</th>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Montant</th>
                            <th class="px-4 py-2 text-left text-gray-600 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($liquidations as $liquidation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-medium text-black-blue">#{{ $liquidation->id }}</td>
                                <td class="px-4 py-2 font-bold text-my-green">${{ number_format($liquidation->montant, 2) }}</td>
                                <td class="px-4 py-2">{{ $liquidation->date_liquidation->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-500">Aucune donnée disponible</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Informations Additionnelles -->
    <div class="space-y-6">
        <!-- Info Box -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Informations</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">Compte Créé</p>
                    <p class="font-medium text-black-blue">{{ $administrateur->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Dernière mise à jour</p>
                    <p class="font-medium text-black-blue">{{ $administrateur->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="pt-3 border-t">
                    <p class="text-gray-600">Liquidations</p>
                    <p class="font-medium text-my-green text-lg">{{ $administrateur->liquidations->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-my-green">
            <h3 class="text-sm font-bold text-my-green uppercase tracking-wide mb-4">Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.administrateurs.edit', $administrateur) }}" class="block px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity text-center font-medium">
                    Éditer
                </a>
                @if(auth('administrateur')->user()->id !== $administrateur->id)
                    <form action="{{ route('admin.administrateurs.destroy', $administrateur) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Supprimer
                        </button>
                    </form>
                @else
                    <div class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-center font-medium text-sm">
                        Vous ne pouvez pas vous supprimer
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
