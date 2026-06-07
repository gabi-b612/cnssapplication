@extends('layouts.admin')

@section('title', 'Éditer Entreprise - Administration CNSS')
@section('page-title', 'Éditer Entreprise')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.entreprises.index') }}" class="text-my-green hover:underline flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Formulaire Principal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-black-blue mb-6">Informations de l'Entreprise</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-800 font-medium">Erreurs de validation</p>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600 text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.entreprises.update', $entreprise) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Raison Sociale -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Raison Sociale *</label>
                        <input type="text" name="raison_sociale" value="{{ old('raison_sociale', $entreprise->raison_sociale) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('raison_sociale') ? 'border-red-500' : '' }}">
                        @error('raison_sociale')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Siège Social -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Siège Social *</label>
                        <input type="text" name="siege_social" value="{{ old('siege_social', $entreprise->siege_social) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('siege_social') ? 'border-red-500' : '' }}">
                        @error('siege_social')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $entreprise->email) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('email') ? 'border-red-500' : '' }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $entreprise->telephone) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green">
                        @error('telephone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Forme Juridique -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Forme Juridique *</label>
                    <input type="text" name="forme_juridique" value="{{ old('forme_juridique', $entreprise->forme_juridique) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('forme_juridique') ? 'border-red-500' : '' }}">
                    @error('forme_juridique')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.entreprises.index') }}" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium text-center">
                        Annuler
                    </a>
                    <button type="submit" class="flex-1 px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Informations Additionnelles -->
    <div class="space-y-6">
        <!-- Info Box -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Informations</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">ID</p>
                    <p class="font-medium text-black-blue">#{{ $entreprise->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Créée le</p>
                    <p class="font-medium text-black-blue">{{ $entreprise->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Dernière modification</p>
                    <p class="font-medium text-black-blue">{{ $entreprise->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Nombre de travailleurs</p>
                    <p class="font-medium text-black-blue">{{ $entreprise->travailleurs->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Actions Dangereuses -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <h3 class="text-sm font-bold text-red-600 uppercase tracking-wide mb-4">Actions Dangereuses</h3>
            <p class="text-xs text-gray-600 mb-4">
                Supprimer cette entreprise supprimera aussi tous les travailleurs et demandes associées.
            </p>
            <form action="{{ route('admin.entreprises.destroy', $entreprise) }}" method="POST"
                  onsubmit="return confirm('Êtes-vous absolument sûr ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Supprimer l'entreprise
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
