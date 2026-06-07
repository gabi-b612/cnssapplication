@extends('layouts.admin')

@section('title', 'Détails Entreprise - Administration CNSS')
@section('page-title', 'Détails de l\'Entreprise')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.entreprises.index') }}" class="text-my-green hover:underline flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informations Principales -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-black-blue">{{ $entreprise->raison_sociale }}</h2>
                <p class="text-gray-600 text-sm mt-1">#{{ $entreprise->id }}</p>
            </div>
            <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2">
                <i class="fas fa-edit"></i>Éditer
            </a>
        </div>

        <div class="space-y-6">
            <!-- Section Informations Générales -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                    <i class="fas fa-building text-my-green"></i>Informations Générales
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Siège Social</p>
                        <p class="text-lg font-medium text-gray-800 mt-1">{{ $entreprise->siege_social }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Forme Juridique</p>
                        <p class="text-lg font-medium text-gray-800 mt-1">{{ $entreprise->forme_juridique }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Email</p>
                        <p class="text-lg font-medium text-my-green mt-1 break-all">{{ $entreprise->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 uppercase tracking-wide font-medium">Téléphone</p>
                        <p class="text-lg font-medium text-gray-800 mt-1">{{ $entreprise->telephone ?? 'Non fourni' }}</p>
                    </div>
                </div>
            </div>

            <!-- Section Travailleurs -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-my-green"></i>Travailleurs ({{ $entreprise->travailleurs->count() }})
                </h3>
                @if($entreprise->travailleurs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Nom</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Prenom</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Email</th>
                                    <th class="px-4 py-2 text-left text-gray-600 font-medium">Sexe</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($entreprise->travailleurs as $travailleur)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $travailleur->nom }}</td>
                                        <td class="px-4 py-2">{{ $travailleur->prenom }}</td>
                                        <td class="px-4 py-2 text-my-green">{{ $travailleur->email }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 bg-gray-100 rounded text-xs">
                                                {{ $travailleur->sexe === 'M' ? 'Masculin' : 'Féminin' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-gray-500">Aucun travailleur enregistré pour cette entreprise.</p>
                    </div>
                @endif
            </div>

            <!-- Section Demandes -->
            <div>
                <h3 class="text-lg font-bold text-black-blue mb-4 flex items-center gap-2">
                    <i class="fas fa-file-contract text-my-green"></i>Demandes ({{ $entreprise->demandes->count() }})
                </h3>
                @if($entreprise->demandes->count() > 0)
                    <div class="space-y-2">
                        @foreach($entreprise->demandes as $demande)
                            <div class="p-3 bg-gray-50 rounded-lg flex items-start justify-between">
                                <div>
                                    <p class="font-medium text-black-blue">#{{ $demande->id }}</p>
                                    <p class="text-sm text-gray-600">{{ $demande->travailleur->prenom }} {{ $demande->travailleur->nom }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Type: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $demande->type_allocation)) }}</span></p>
                                </div>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ $demande->statut === 'validee' ? 'bg-green-100 text-green-700' : ($demande->statut === 'rejetee' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-gray-50 rounded-lg text-center">
                        <p class="text-gray-500">Aucune demande enregistrée pour cette entreprise.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Informations Additionnelles -->
    <div class="space-y-6">
        <!-- Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Statistiques</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Travailleurs</span>
                    <span class="text-2xl font-bold text-my-green">{{ $entreprise->travailleurs->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Demandes</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $entreprise->demandes->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Validées</span>
                    <span class="text-2xl font-bold text-green-600">{{ $entreprise->demandes->where('statut', 'validee')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Rejetées</span>
                    <span class="text-2xl font-bold text-red-600">{{ $entreprise->demandes->where('statut', 'rejetee')->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Informations</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">Créée le</p>
                    <p class="font-medium text-black-blue">{{ $entreprise->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Dernière mise à jour</p>
                    <p class="font-medium text-black-blue">{{ $entreprise->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-my-green">
            <h3 class="text-sm font-bold text-my-green uppercase tracking-wide mb-4">Actions</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="block px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity text-center font-medium">
                    Éditer
                </a>
                <form action="{{ route('admin.entreprises.destroy', $entreprise) }}" method="POST" 
                      onsubmit="return confirm('Êtes-vous sûr ? Cette action supprimera aussi tous les travailleurs et demandes.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
