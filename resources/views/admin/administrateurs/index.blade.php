@extends('layouts.admin')

@section('title', 'Gestionnaires RH - Gestionnaire RH CNSS')
@section('page-title', 'Gestion des Gestionnaires RH')

@section('content')
<div class="mb-6 flex items-center justify-end">
    <x-modal
        id="modal-admin"
        title="Ajouter un Gestionnaire RH"
        submit-text="Créer"
        form-id="modal-form-admin"
        :open-on-load="$errors->any()"
    >
        <x-slot:trigger>
            <button type="button" class="px-5 py-2.5 bg-my-green text-white rounded-lg hover:opacity-90 transition-opacity font-medium flex items-center gap-2 shadow-sm">
                <i class="fas fa-plus"></i>Ajouter un gestionnaire RH
            </button>
        </x-slot:trigger>

        <form action="{{ route('admin.administrateurs.store') }}" method="POST" id="modal-form-admin" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('nom') ? 'border-red-500' : '' }}">
                @error('nom')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('prenom') ? 'border-red-500' : '' }}">
                @error('prenom')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('email') ? 'border-red-500' : '' }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fonction *</label>
                <select name="fonction" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('fonction') ? 'border-red-500' : '' }}">
                    <option value="">Sélectionnez une fonction</option>
                    <option value="Gestionnaire RH" @selected(old('fonction') === 'Gestionnaire RH')>Gestionnaire RH</option>
                    <option value="Auditeur" @selected(old('fonction') === 'Auditeur')>Auditeur</option>
                    <option value="Super Administrateur" @selected(old('fonction') === 'Super Administrateur')>Super Gestionnaire RH</option>
                    <option value="Coordinateur" @selected(old('fonction') === 'Coordinateur')>Coordinateur</option>
                </select>
                @error('fonction')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mot de Passe *</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green {{ $errors->has('password') ? 'border-red-500' : '' }}">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le Mot de Passe *</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-my-green/50 focus:border-my-green">
            </div>
        </form>
    </x-modal>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Nom Complet
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Fonction
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Date Création
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($administrateurs as $admin)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-black-blue">{{ $admin->nom }} {{ $admin->prenom }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $admin->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <span class="inline-block px-3 py-1 bg-my-green/10 text-my-green rounded-full text-xs font-medium">
                                {{ $admin->fonction }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $admin->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.administrateurs.show', $admin) }}" class="text-my-green hover:text-black-blue transition-colors mr-3" title="Voir les détails">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.administrateurs.edit', $admin) }}" class="text-blue-600 hover:text-blue-900 transition-colors mr-3" title="Éditer">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.administrateurs.destroy', $admin) }}"
                                  class="inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce gestionnaire RH ?');">
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
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <i class="fas fa-users text-gray-300 text-3xl"></i>
                                <p class="text-gray-500 font-medium">Aucun gestionnaire RH enregistré</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($administrateurs->hasPages())
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $administrateurs->links() }}
        </div>
    @endif
</div>
@endsection
