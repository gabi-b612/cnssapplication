@props([
    'id' => 'modal',
    'title' => 'Modal',
    'submitText' => 'Enregistrer',
    'submitClass' => 'bg-my-green',
    'formId' => 'modal-form',
    'openOnLoad' => false,
])

<div
    x-data="{ open: {{ $openOnLoad ? 'true' : 'false' }} }"
    @keydown.escape.window="open = false"
    {{ $attributes->merge(['class' => 'contents']) }}
>
    @isset($trigger)
        <div @click="open = true">
            {{ $trigger }}
        </div>
    @endisset

    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto"
        role="dialog"
        aria-modal="true"
        aria-labelledby="{{ $id }}-title"
    >
        <div
            class="fixed inset-0 bg-black/50 transition-opacity"
            @click="open = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div
                class="relative bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto"
                @click.stop
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 id="{{ $id }}-title" class="text-lg font-semibold text-black-blue">{{ $title }}</h3>
                    <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    {{ $slot }}
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex gap-3 sticky bottom-0">
                    <button
                        type="button"
                        @click="open = false"
                        class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium"
                    >
                        Annuler
                    </button>
                    <button
                        type="submit"
                        form="{{ $formId }}"
                        class="flex-1 px-4 py-2.5 {{ $submitClass }} text-white rounded-lg hover:opacity-90 transition-opacity font-medium"
                    >
                        {{ $submitText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
