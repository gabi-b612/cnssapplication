@extends('layouts.admin')

@section('title', 'Éditer Agent APF - Administration CNSS')
@section('page-title', 'Éditer Agent APF')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.apfs.index') }}" class="text-my-green hover:underline flex items-center gap-2 text-sm font-medium">
        <i class="fas fa-arrow-left"></i>Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-black-blue mb-6">Informations de l'agent APF</h2>

            <form action="{{ route('admin.apfs.update', $apf) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                        <input type="text" name="nom" value="{{ old('nom', $apf->nom) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $apf->prenom) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $apf->email) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
                    <p class="text-xs text-gray-500 mt-1">Laisser vide pour conserver le mot de passe actuel.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.apfs.index') }}" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium text-center">
                        Annuler
                    </a>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Informations</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">ID</p>
                    <p class="font-medium text-black-blue">#{{ $apf->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Créé le</p>
                    <p class="font-medium text-black-blue">{{ $apf->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Demandes traitées</p>
                    <p class="font-medium text-my-green">{{ $apf->demandes()->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-red-500">
            <h3 class="text-sm font-bold text-red-600 uppercase tracking-wide mb-4">Suppression</h3>
            <form action="{{ route('admin.apfs.destroy', $apf) }}" method="POST"
                  onsubmit="return confirm('Supprimer cet agent APF ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Supprimer l'agent APF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
