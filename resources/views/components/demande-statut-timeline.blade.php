@props(['historiques'])

<div class="space-y-0">
    @forelse($historiques as $index => $historique)
        <div class="relative flex gap-4 pb-8 last:pb-0">
            @if(!$loop->last)
                <span class="absolute left-[11px] top-6 bottom-0 w-0.5 bg-gray-200" aria-hidden="true"></span>
            @endif

            <div class="relative z-10 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-my-green text-white text-xs">
                <i class="fas {{ \App\Models\Demande::statutIcon($historique->nouveau_statut) }}"></i>
            </div>

            <div class="min-w-0 flex-1 pt-0.5">
                <div class="flex flex-wrap items-center gap-2">
                    <x-demande-statut-badge :statut="$historique->nouveau_statut" />
                    <span class="text-xs text-gray-500">{{ $historique->created_at->format('d/m/Y à H:i') }}</span>
                </div>

                @if($historique->ancien_statut)
                    <p class="text-xs text-gray-500 mt-1">
                        Depuis : {{ $historique->ancien_statut_label }}
                    </p>
                @endif

                @if($historique->acteur_type && $historique->acteur_type !== 'system')
                    <p class="text-xs text-gray-600 mt-1">
                        @switch($historique->acteur_type)
                            @case('entreprise')
                                <i class="fas fa-building mr-1 text-my-green"></i>Employeur
                                @break
                            @case('apf')
                                <i class="fas fa-user-shield mr-1 text-my-green"></i>Agent APF
                                @break
                            @case('administrateur')
                                <i class="fas fa-user-tie mr-1 text-my-green"></i>Administrateur
                                @break
                        @endswitch
                    </p>
                @endif
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-500">Aucun historique de statut disponible.</p>
    @endforelse
</div>
