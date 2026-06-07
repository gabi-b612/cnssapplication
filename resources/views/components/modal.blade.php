@props(['id' => 'modal', 'title' => 'Modal', 'submitText' => 'Enregistrer', 'submitClass' => 'bg-my-green'])

<div x-data="{ open: false }" @keydown.escape="open = false" class="relative">
    <!-- Trigger Slot -->
    <div @click="open = true">
        {{ $trigger ?? '' }}
    </div>

    <!-- Modal Backdrop -->
    <div x-show="open" @click="open = false" x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-40"></div>

    <!-- Modal -->
    <div x-show="open" @click.away="open = false" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95" 
         class="fixed inset-0 flex items-center justify-center z-50 p-4">
        
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-screen overflow-y-auto">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-bold text-black-blue">{{ $title }}</h3>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Body -->
            <form @submit.prevent="$dispatch('submit')" class="p-6 space-y-4">
                {{ $content ?? '' }}
            </form>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex gap-3 sticky bottom-0">
                <button @click="open = false" type="button" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                    Annuler
                </button>
                <button form="modal-form" type="submit" 
                        class="flex-1 px-4 py-2 {{ $submitClass }} text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                    {{ $submitText }}
                </button>
            </div>
        </div>
    </div>
</div>
