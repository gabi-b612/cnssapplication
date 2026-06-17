@props(['demande', 'index', 'label' => null])

<a href="{{ route('documents.show', ['demande' => $demande, 'index' => $index]) }}"
   target="_blank"
   rel="noopener noreferrer"
   {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 text-my-green hover:underline text-sm']) }}>
    <i class="fas fa-file-pdf"></i>{{ $label ?? 'Document ' . ($index + 1) }}
    <i class="fas fa-external-link-alt text-xs opacity-60" title="Ouvre dans un nouvel onglet"></i>
</a>
