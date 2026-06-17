<?php

namespace App\Http\Requests\Travailleur\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreReclamationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('travailleur')->check();
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'Le message de réclamation est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'message.max' => 'Le message ne peut pas dépasser 2000 caractères.',
        ];
    }
}
