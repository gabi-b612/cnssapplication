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
@endsection
