@props(['statut'])

@php
    $label = \App\Models\Demande::statutLabel($statut);
    $classes = \App\Models\Demande::statutBadgeClasses($statut);
    $icon = \App\Models\Demande::statutIcon($statut);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {$classes}"]) }}>
    <i class="fas {{ $icon }} mr-1"></i>{{ $label }}
</span>
