<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreLiquidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'demande_id' => 'required|exists:demandes,id',
            'montant' => 'required|numeric|gt:0',
            'date_liquidation' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'demande_id.required' => 'La demande est requise.',
            'demande_id.exists' => 'La demande sélectionnée n\'existe pas.',
            'montant.required' => 'Le montant est requis.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.gt' => 'Le montant doit être strictement supérieur à 0.',
            'date_liquidation.required' => 'La date de liquidation est requise.',
            'date_liquidation.date' => 'Veuillez fournir une date valide.',
        ];
    }
}
