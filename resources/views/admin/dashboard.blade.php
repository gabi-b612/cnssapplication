@extends('layouts.admin')

@section('title', 'Dashboard - Administration CNSS')
@section('page-title', 'Tableau de Bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card Entreprises -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-my-green">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Entreprises</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['entreprises'] ?? 0 }}</p>
            </div>
            <div class="bg-my-green/10 p-4 rounded-lg">
                <i class="fas fa-building text-my-green text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.entreprises.index') }}" class="text-my-green text-sm font-medium mt-4 inline-block hover:underline">
            Voir les détails →
        </a>
    </div>

    <!-- Card Administrateurs -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Administrateurs</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['administrateurs'] ?? 0 }}</p>
            </div>
            <div class="bg-blue-500/10 p-4 rounded-lg">
                <i class="fas fa-users text-blue-500 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card Liquidations -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Liquidations</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['liquidations'] ?? 0 }}</p>
            </div>
            <div class="bg-yellow-500/10 p-4 rounded-lg">
                <i class="fas fa-money-bill-wave text-yellow-500 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Card Demandes -->
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Demandes</p>
                <p class="text-3xl font-bold text-black-blue mt-2">{{ $stats['demandes'] ?? 0 }}</p>
            </div>
            <div class="bg-purple-500/10 p-4 rounded-lg">
                <i class="fas fa-file-contract text-purple-500 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

</div>
@endsection
