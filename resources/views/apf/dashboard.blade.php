@extends('layouts.apf')

@section('title', 'Dashboard - CNSS APF')
@section('page-title', 'Tableau de Bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">En attente</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['en_attente'] }}</p>
            </div>
            <div class="bg-yellow-500/10 p-4 rounded-lg">
                <i class="fas fa-clock text-yellow-500 text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('apf.demandes.index') }}" class="text-my-green text-sm font-medium mt-4 inline-block hover:underline">
            Traiter →
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-my-green">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Validées</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['validees'] }}</p>
            </div>
            <div class="bg-my-green/10 p-4 rounded-lg">
                <i class="fas fa-check-circle text-my-green text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Rejetées</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['rejetees'] }}</p>
            </div>
            <div class="bg-red-500/10 p-4 rounded-lg">
                <i class="fas fa-times-circle text-red-500 text-2xl"></i>
            </div>
        </div>
    </div>
</div>
@endsection
