<?php

namespace App\Http\Requests\Apf\Validation;

use App\Models\Demande;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValiderDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('apf')->check();
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', Rule::in([Demande::STATUT_APPROUVEE, Demande::STATUT_REJETEE])],
            'motif_rejet' => ['nullable', 'string', 'max:1000', 'required_if:statut,' . Demande::STATUT_REJETEE],
        ];
    }

    public function messages(): array
    {
        return [
            'statut.required' => 'Le statut est requis.',
            'statut.in' => 'Le statut doit être : approuvée ou rejetée.',
            'motif_rejet.required_if' => 'Le motif du rejet est obligatoire.',
        ];
    }
}
