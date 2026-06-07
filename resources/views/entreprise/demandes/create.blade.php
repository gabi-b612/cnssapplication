@extends('layouts.entreprise')

@section('title', 'Nouvelle Demande - CNSS')
@section('page-title', 'Nouvelle Demande')

@section('content')
<div class="mb-6">
    <a href="{{ route('entreprise.demandes.index') }}" class="text-my-green hover:underline flex items-center gap-2 text-sm font-medium">
        <i class="fas fa-arrow-left"></i>Retour aux demandes
    </a>
</div>

<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-8">
    @if($travailleurs->isEmpty())
        <div class="text-center py-8">
            <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
            <p class="text-gray-600 font-medium mb-4">Vous devez d'abord enregistrer au moins un travailleur.</p>
            <a href="{{ route('entreprise.travailleurs.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                <i class="fas fa-plus"></i>Ajouter un travailleur
            </a>
        </div>
    @else
        <form action="{{ route('entreprise.demandes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Travailleur concerné *</label>
                <select name="travailleur_id" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('travailleur_id') ? 'border-red-500' : '' }}">
                    <option value="">Sélectionnez un travailleur</option>
                    @foreach($travailleurs as $travailleur)
                        <option value="{{ $travailleur->id }}" @selected(old('travailleur_id') == $travailleur->id)>
                            {{ $travailleur->nom }} {{ $travailleur->postnom }} {{ $travailleur->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('travailleur_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type d'allocation *</label>
                <select name="type_allocation" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('type_allocation') ? 'border-red-500' : '' }}">
                    <option value="">Sélectionnez le type</option>
                    <option value="familiale" @selected(old('type_allocation') === 'familiale')>Allocation familiale</option>
                    <option value="maternite" @selected(old('type_allocation') === 'maternite')>Allocation maternité</option>
                    <option value="prenatale" @selected(old('type_allocation') === 'prenatale')>Allocation prénatale</option>
                </select>
                @error('type_allocation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Documents justificatifs (PDF) *</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-my-green/50 transition-colors"
                     x-data="{ files: null }">
                    <i class="fas fa-file-pdf text-my-green text-3xl mb-3"></i>
                    <p class="text-sm text-gray-600 mb-3">Sélectionnez un ou plusieurs fichiers PDF (max 2 Mo chacun)</p>
                    <input type="file" name="documents[]" multiple accept=".pdf,application/pdf" required
                           @change="files = $event.target.files.length"
                           class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-my-green file:text-white hover:file:opacity-90 file:cursor-pointer {{ $errors->has('documents') || $errors->has('documents.*') ? 'border-red-500' : '' }}">
                    <p x-show="files" x-cloak class="text-xs text-my-green mt-2" x-text="files + ' fichier(s) sélectionné(s)'"></p>
                </div>
                @error('documents')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('documents.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('entreprise.demandes.index') }}" class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium text-center">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                    <i class="fas fa-paper-plane mr-1"></i>Soumettre la demande
                </button>
            </div>
        </form>
    @endif
</div>
@endsection
