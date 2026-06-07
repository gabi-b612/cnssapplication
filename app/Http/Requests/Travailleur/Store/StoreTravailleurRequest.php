<?php

namespace App\Http\Requests\Travailleur\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravailleurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'entreprise_id' => 'required|exists:entreprises,id',
            'nom' => 'required|string|max:255',
            'postnom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:travailleurs,email',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:M,F',
            'etat_civil' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'entreprise_id.required' => 'L\'ID de l\'entreprise est requis.',
            'entreprise_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
            'nom.required' => 'Le nom est requis.',
            'nom.string' => 'Le nom doit être un texte.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'postnom.required' => 'Le postnom est requis.',
            'postnom.string' => 'Le postnom doit être un texte.',
            'postnom.max' => 'Le postnom ne doit pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.string' => 'Le prénom doit être un texte.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.string' => 'Le mot de passe doit être un texte.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'telephone.string' => 'Le téléphone doit être un texte.',
            'telephone.max' => 'Le téléphone ne doit pas dépasser 20 caractères.',
            'date_naissance.required' => 'La date de naissance est requise.',
            'date_naissance.date' => 'Veuillez fournir une date valide.',
            'sexe.required' => 'Le sexe est requis.',
            'sexe.in' => 'Le sexe doit être M ou F.',
            'etat_civil.string' => 'L\'état civil doit être un texte.',
            'etat_civil.max' => 'L\'état civil ne doit pas dépasser 255 caractères.',
        ];
    }
}
