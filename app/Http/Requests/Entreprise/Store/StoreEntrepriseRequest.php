<?php

namespace App\Http\Requests\Entreprise\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntrepriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'raison_sociale' => 'required|string|max:255',
            'siege_social' => 'required|string|max:255',
            'email' => 'required|email|unique:entreprises,email',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'raison_sociale.required' => 'La raison sociale est requise.',
            'raison_sociale.string' => 'La raison sociale doit être un texte.',
            'raison_sociale.max' => 'La raison sociale ne doit pas dépasser 255 caractères.',
            'siege_social.required' => 'Le siège social est requis.',
            'siege_social.string' => 'Le siège social doit être un texte.',
            'siege_social.max' => 'Le siège social ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être un texte.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'telephone.string' => 'Le téléphone doit être un texte.',
            'telephone.max' => 'Le téléphone ne doit pas dépasser 20 caractères.',
        ];
    }
}
