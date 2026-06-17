@props(['demande', 'showTravailleur' => true, 'showEntreprise' => false])

@php
    $montantReference = app(\App\Services\AllocationCalculator::class)->montantPourType($demande->type_allocation);
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Référence</p>
                    <h3 class="text-2xl font-bold text-black-blue">#{{ $demande->id }}</h3>
                </div>
                <x-demande-statut-badge :statut="$demande->statut" class="text-sm" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Type d'allocation</p>
                    <p class="text-black-blue font-medium mt-1">{{ ucfirst(str_replace('_', ' ', $demande->type_allocation)) }}</p>
                </div>

                @if($demande->statut !== \App\Models\Demande::STATUT_REJETEE)
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">
                            {{ $demande->statut === \App\Models\Demande::STATUT_PAYEE ? 'Montant versé' : 'Montant de référence' }}
                        </p>
                        @if($demande->statut === \App\Models\Demande::STATUT_PAYEE && $demande->liquidation)
                            <p class="text-my-green font-bold text-lg mt-1">{{ \App\Services\AllocationCalculator::formaterMontant($demande->liquidation->montant) }}</p>
                            <p class="text-xs text-gray-500 mt-1">Liquidée le {{ $demande->liquidation->date_liquidation->format('d/m/Y') }}</p>
                        @else
                            <p class="text-my-green font-bold text-lg mt-1">{{ \App\Services\AllocationCalculator::formaterMontant($montantReference) }}</p>
                        @endif
                    </div>
                @endif
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Date de soumission</p>
                    <p class="text-black-blue font-medium mt-1">{{ $demande->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Dernière mise à jour</p>
                    <p class="text-black-blue font-medium mt-1">{{ $demande->updated_at->format('d/m/Y à H:i') }}</p>
                </div>

                @if($demande->apf)
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Agent traitant</p>
                        <p class="text-black-blue font-medium mt-1">{{ $demande->apf->prenom }} {{ $demande->apf->nom }}</p>
                    </div>
                @endif
            </div>

            @if($demande->statut === \App\Models\Demande::STATUT_REJETEE && $demande->motif_rejet)
                <div class="mt-6 p-4 bg-red-50 border border-red-100 rounded-lg">
                    <p class="text-xs text-red-700 uppercase tracking-wide font-medium mb-1">Motif du rejet</p>
                    <p class="text-sm text-red-800">{{ $demande->motif_rejet }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-lg font-semibold text-black-blue mb-4 flex items-center gap-2">
                <i class="fas fa-file-pdf text-my-green"></i>Documents
            </h4>

            @if($demande->documents && count($demande->documents) > 0)
                <ul class="space-y-2">
                    @foreach($demande->documents as $index => $document)
                        <li>
                            <a href="{{ asset('storage/' . $document) }}" target="_blank"
                               class="inline-flex items-center gap-2 text-my-green hover:underline text-sm">
                                <i class="fas fa-file-pdf"></i>Document {{ $index + 1 }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500">Aucun document joint.</p>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        @if($showTravailleur && $demande->travailleur)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Travailleur</h4>
                <p class="font-medium text-black-blue">{{ $demande->travailleur->nom }} {{ $demande->travailleur->postnom }} {{ $demande->travailleur->prenom }}</p>
                <p class="text-sm text-gray-600 mt-2">{{ $demande->travailleur->email }}</p>
            </div>
        @endif

        @if($showEntreprise && $demande->entreprise)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4">Entreprise</h4>
                <p class="font-medium text-black-blue">{{ $demande->entreprise->raison_sociale }}</p>
                <p class="text-sm text-gray-600 mt-2">{{ $demande->entreprise->email }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-bold text-black-blue uppercase tracking-wide mb-4 flex items-center gap-2">
                <i class="fas fa-history text-my-green"></i>Historique des statuts
            </h4>
            <x-demande-statut-timeline :historiques="$demande->statutHistoriques" />
        </div>
    </div>
</div>
