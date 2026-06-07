<?php

namespace App\Http\Requests\Admin\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('administrateur')->check();
    }

    public function rules(): array
    {
        $apfId = $this->route('apf')->id;

        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('apfs', 'email')->ignore($apfId)],
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
