@extends('layouts.entreprise')

@section('title', 'Éditer Travailleur - CNSS')
@section('page-title', 'Éditer Travailleur')

@section('content')
<div class="mb-6">
    <a href="{{ route('entreprise.travailleurs.index') }}" class="text-my-green hover:underline flex items-center gap-2 text-sm font-medium">
        <i class="fas fa-arrow-left"></i>Retour à la liste
    </a>
</div>

<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-8">
    <h3 class="text-lg font-semibold text-black-blue mb-6">{{ $travailleur->nom }} {{ $travailleur->postnom }} {{ $travailleur->prenom }}</h3>

    <form action="{{ route('entreprise.travailleurs.update', $travailleur) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom', $travailleur->nom) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Postnom *</label>
                <input type="text" name="postnom" value="{{ old('postnom', $travailleur->postnom) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom', $travailleur->prenom) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
            <input type="email" name="email" value="{{ old('email', $travailleur->email) }}" required
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $travailleur->telephone) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance *</label>
                <input type="date" name="date_naissance" value="{{ old('date_naissance', $travailleur->date_naissance->format('Y-m-d')) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sexe *</label>
                <select name="sexe" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
                    <option value="M" @selected(old('sexe', $travailleur->sexe) === 'M')>Masculin</option>
                    <option value="F" @selected(old('sexe', $travailleur->sexe) === 'F')>Féminin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">État civil</label>
                <input type="text" name="etat_civil" value="{{ old('etat_civil', $travailleur->etat_civil) }}"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
            </div>
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

        <div class="flex gap-3 pt-4">
            <a href="{{ route('entreprise.travailleurs.index') }}" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium text-center">
                Annuler
            </a>
            <button type="submit" class="flex-1 px-4 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
