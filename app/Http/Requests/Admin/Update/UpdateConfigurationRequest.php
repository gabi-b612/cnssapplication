<?php

namespace App\Http\Requests\Admin\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'taux_cotisation' => 'required|numeric|min:0|max:100',
            'montant_allocation_familiale' => 'required|numeric|min:1',
            'montant_allocation_maternite' => 'required|numeric|min:1',
            'montant_allocation_prenatale' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'taux_cotisation.required' => 'Le taux de cotisation est requis.',
            'taux_cotisation.numeric' => 'Le taux de cotisation doit être un nombre.',
            'taux_cotisation.min' => 'Le taux de cotisation ne peut pas être négatif.',
            'taux_cotisation.max' => 'Le taux de cotisation ne peut pas dépasser 100%.',
            'montant_allocation_familiale.required' => 'Le montant familiale est requis.',
            'montant_allocation_maternite.required' => 'Le montant maternité est requis.',
            'montant_allocation_prenatale.required' => 'Le montant prénatale est requis.',
            'montant_allocation_familiale.min' => 'Le montant familiale doit être supérieur à 0.',
            'montant_allocation_maternite.min' => 'Le montant maternité doit être supérieur à 0.',
            'montant_allocation_prenatale.min' => 'Le montant prénatale doit être supérieur à 0.',
        ];
    }
}
