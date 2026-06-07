<?php

namespace App\Http\Requests\Entreprise\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTravailleurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('entreprise')->check()
            && $this->route('travailleur')->entreprise_id === auth('entreprise')->id();
    }

    public function rules(): array
    {
        $travailleurId = $this->route('travailleur')->id;

        return [
            'nom' => 'required|string|max:255',
            'postnom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('travailleurs', 'email')->ignore($travailleurId)],
            'password' => 'nullable|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date|before:today',
            'sexe' => 'required|in:M,F',
            'etat_civil' => 'nullable|string|max:255',
        ];
    }
}
