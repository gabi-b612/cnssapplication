@extends('layouts.admin')

@section('title', 'Entreprises - Administration CNSS')
@section('page-title', 'Gestion des Entreprises')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <p class="text-gray-600">Gérez l'ensemble des entreprises enregistrées dans le système.</p>
    <button @click="$refs.modalEntreprise.open = true" class="px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2">
        <i class="fas fa-plus"></i>Ajouter une entreprise
    </button>
</div>

<!-- Tableau des Entreprises -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Raison Sociale
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Téléphone
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Forme Juridique
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Date
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($entreprises as $entreprise)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-black-blue">{{ $entreprise->raison_sociale }}</div>
                            <div class="text-xs text-gray-500">{{ $entreprise->siege_social }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $entreprise->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $entreprise->telephone ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $entreprise->forme_juridique }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $entreprise->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.entreprises.show', $entreprise) }}" class="text-blue-600 hover:text-blue-900 transition-colors mr-3" title="Voir les détails">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="text-blue-600 hover:text-blue-900 transition-colors mr-3" title="Éditer">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.entreprises.destroy', $entreprise) }}" 
                                  class="inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                                <p class="text-gray-500 font-medium">Aucune entreprise trouvée</p>
                                <p class="text-sm text-gray-400">Créez une nouvelle entreprise pour commencer.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($entreprises->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $entreprises->links() }}
        </div>
    @endif
</div>

<!-- Modal Ajouter/Éditer Entreprise -->
<div x-data="{ open: false }" @keydown.escape="open = false" x-ref="modalEntreprise" class="relative">
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
                <h3 class="text-lg font-bold text-black-blue">Ajouter une Entreprise</h3>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Body -->
            <form action="{{ route('admin.entreprises.store') }}" method="POST" id="modal-form" class="p-6 space-y-4">
                @csrf

                <!-- Raison Sociale -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Raison Sociale *</label>
                    <input type="text" name="raison_sociale" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('raison_sociale') ? 'border-red-500' : '' }}"
                           placeholder="Ex: Société XYZ">
                    @error('raison_sociale')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Siège Social -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Siège Social *</label>
                    <input type="text" name="siege_social" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('siege_social') ? 'border-red-500' : '' }}"
                           placeholder="Ex: Kinshasa, RDC">
                    @error('siege_social')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('email') ? 'border-red-500' : '' }}"
                           placeholder="entreprise@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                    <input type="text" name="telephone"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green"
                           placeholder="+243 XX XXX XXXX">
                    @error('telephone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Forme Juridique -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Forme Juridique *</label>
                    <input type="text" name="forme_juridique" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('forme_juridique') ? 'border-red-500' : '' }}"
                           placeholder="Ex: SARL, SA, EIRL">
                    @error('forme_juridique')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de Passe *</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green {{ $errors->has('password') ? 'border-red-500' : '' }}"
                           placeholder="Minimum 8 caractères">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le Mot de Passe *</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green"
                           placeholder="Confirmez le mot de passe">
                </div>
            </form>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex gap-3 sticky bottom-0">
                <button @click="open = false" type="button" 
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                    Annuler
                </button>
                <button form="modal-form" type="submit" 
                        class="flex-1 px-4 py-2 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium">
                    Créer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
