<?php

namespace App\Http\Requests\Admin\Store;

use App\Models\Demande;
use App\Services\AllocationCalculator;
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
            'demande_id' => 'required|exists:demandes,id|unique:liquidations,demande_id',
            'montant' => 'required|numeric|gt:0',
            'date_liquidation' => 'required|date|before_or_equal:today',
            'justification_ajustement' => 'nullable|string|max:1000',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $demande = Demande::find($this->input('demande_id'));

            if (!$demande || !$this->filled('montant')) {
                return;
            }

            $montantSuggere = app(AllocationCalculator::class)->montantPourType($demande->type_allocation);

            if ((float) $this->input('montant') !== (float) $montantSuggere && !$this->filled('justification_ajustement')) {
                $validator->errors()->add(
                    'justification_ajustement',
                    'Une justification est obligatoire lorsque le montant diffère du montant de référence.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'demande_id.required' => 'La demande est requise.',
            'demande_id.exists' => 'La demande sélectionnée n\'existe pas.',
            'demande_id.unique' => 'Cette demande a déjà été liquidée.',
            'montant.required' => 'Le montant est requis.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'montant.gt' => 'Le montant doit être strictement supérieur à 0.',
            'date_liquidation.required' => 'La date de liquidation est requise.',
            'date_liquidation.date' => 'Veuillez fournir une date valide.',
            'date_liquidation.before_or_equal' => 'La date de liquidation ne peut pas être dans le futur.',
        ];
    }
}
