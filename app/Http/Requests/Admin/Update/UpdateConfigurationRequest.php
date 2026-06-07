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
            'taux_allocation_familiale' => 'required|numeric|min:0|max:100',
            'taux_allocation_maternite' => 'required|numeric|min:0|max:100',
            'taux_allocation_prenatale' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'taux_cotisation.required' => 'Le taux de cotisation est requis.',
            'taux_cotisation.numeric' => 'Le taux de cotisation doit être un nombre.',
            'taux_cotisation.min' => 'Le taux de cotisation ne peut pas être négatif.',
            'taux_cotisation.max' => 'Le taux de cotisation ne peut pas dépasser 100%.',
            'taux_allocation_familiale.required' => 'Le taux d\'allocation familiale est requis.',
            'taux_allocation_maternite.required' => 'Le taux d\'allocation maternité est requis.',
            'taux_allocation_prenatale.required' => 'Le taux d\'allocation prénatale est requis.',
        ];
    }
}
