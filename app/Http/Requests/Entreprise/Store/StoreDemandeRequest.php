<?php

namespace App\Http\Requests\Entreprise\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDemandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('entreprise')->check();
    }

    public function rules(): array
    {
        $entrepriseId = auth('entreprise')->id();

        return [
            'travailleur_id' => [
                'required',
                Rule::exists('travailleurs', 'id')->where('entreprise_id', $entrepriseId),
            ],
            'type_allocation' => 'required|in:familiale,maternite,prenatale',
            'documents' => 'required|array|min:1',
            'documents.*' => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'travailleur_id.required' => 'Le travailleur est requis.',
            'travailleur_id.exists' => 'Le travailleur sélectionné n\'appartient pas à votre entreprise.',
            'type_allocation.required' => 'Le type d\'allocation est requis.',
            'type_allocation.in' => 'Le type d\'allocation doit être : familiale, maternité ou prénatale.',
            'documents.required' => 'Vous devez joindre au moins un document.',
            'documents.array' => 'Les documents doivent être un tableau de fichiers.',
            'documents.min' => 'Vous devez joindre au moins un document.',
            'documents.*.required' => 'Un document manquant est requis.',
            'documents.*.file' => 'Chaque élément doit être un fichier.',
            'documents.*.mimes' => 'Chaque fichier doit être en format PDF.',
            'documents.*.max' => 'Chaque fichier ne doit pas dépasser 2 Mo.',
        ];
    }
}
