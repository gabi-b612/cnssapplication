@extends('layouts.travailleur')

@section('title', 'Détail demande #' . $demande->id . ' - CNSS')
@section('page-title', 'Détail de ma demande #' . $demande->id)

@section('content')
<div class="mb-6">
    <a href="{{ route('travailleur.dashboard') }}#mes-demandes" class="text-my-green hover:underline flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>Retour à mes demandes
    </a>
</div>

<x-demande-detail :demande="$demande" :show-travailleur="false" :show-entreprise="true" />

@if(in_array($demande->statut, [\App\Models\Demande::STATUT_REJETEE, \App\Models\Demande::STATUT_EN_VERIFICATION], true))
<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h4 class="text-lg font-semibold text-black-blue mb-4 flex items-center gap-2">
        <i class="fas fa-comment-dots text-my-green"></i>Déposer une réclamation
    </h4>
    <p class="text-sm text-gray-600 mb-4">
        Vous pouvez contester cette décision ou demander des clarifications. Votre message sera transmis à la CNSS.
    </p>
    <form action="{{ route('travailleur.demandes.reclamations.store', $demande) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Votre message *</label>
            <textarea name="message" rows="4" required minlength="10" maxlength="2000"
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('message') ? 'border-red-500' : '' }}"
                      placeholder="Décrivez votre réclamation (minimum 10 caractères)...">{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-5 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
            <i class="fas fa-paper-plane mr-1"></i>Envoyer la réclamation
        </button>
    </form>
</div>
@endif

@if($demande->reclamations->isNotEmpty())
<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <h4 class="text-lg font-semibold text-black-blue mb-4 flex items-center gap-2">
        <i class="fas fa-inbox text-my-green"></i>Mes réclamations
    </h4>
    <div class="space-y-4">
        @foreach($demande->reclamations->sortByDesc('created_at') as $reclamation)
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                    <span class="text-xs text-gray-500">{{ $reclamation->created_at->format('d/m/Y à H:i') }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $reclamation->statut === \App\Models\Reclamation::STATUT_TRAITEE ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $reclamation->statut === \App\Models\Reclamation::STATUT_TRAITEE ? 'Traitée' : 'En attente' }}
                    </span>
                </div>
                <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $reclamation->message }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
