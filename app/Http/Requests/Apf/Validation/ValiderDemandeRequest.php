<?php

namespace App\Http\Requests\Apf\Validation;

use Illuminate\Foundation\Http\FormRequest;

class ValiderDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('apf')->check();
    }

    public function rules(): array
    {
        return [
            'statut' => 'required|in:validee,rejetee',
        ];
    }

    public function messages(): array
    {
        return [
            'statut.required' => 'Le statut est requis.',
            'statut.in' => 'Le statut doit être : validée ou rejetée.',
        ];
    }
}
