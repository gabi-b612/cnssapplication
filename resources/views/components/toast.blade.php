@props(['type' => 'success', 'message'])

<div x-data="{ show: true }" x-show="show" x-cloak x-transition
     class="fixed top-4 right-4 z-50 max-w-sm"
     @init="setTimeout(() => show = false, 5000)">
    
    <div class="rounded-lg shadow-lg p-4 {{ $type === 'success' ? 'bg-my-green text-white' : 'bg-red-500 text-white' }}">
        <div class="flex items-center gap-3">
            <div>
                @if ($type === 'success')
                    <i class="fas fa-check-circle text-lg"></i>
                @else
                    <i class="fas fa-exclamation-circle text-lg"></i>
                @endif
            </div>
            <div>
                <p class="font-medium">
                    {{ $type === 'success' ? 'Succès' : 'Erreur' }}
                </p>
                <p class="text-sm opacity-90">{{ $message }}</p>
            </div>
            <button @click="show = false" class="ml-auto hover:opacity-75 transition-opacity">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
