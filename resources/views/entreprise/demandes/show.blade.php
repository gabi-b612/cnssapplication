@extends('layouts.entreprise')

@section('title', 'Détail demande #' . $demande->id . ' - CNSS')
@section('page-title', 'Détail de la demande #' . $demande->id)

@section('content')
<div class="mb-6">
    <a href="{{ route('entreprise.demandes.index') }}" class="text-my-green hover:underline flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>Retour à mes demandes
    </a>
</div>

<x-demande-detail :demande="$demande" :show-travailleur="true" :show-entreprise="false" />
@endsection
