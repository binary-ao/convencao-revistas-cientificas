<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstitutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('program.manage');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'acronym' => ['nullable', 'string', 'max:50'],
            'type' => ['required', 'in:ies,centro_investigacao,orgao_governamental,rede_cientifica,revista_cientifica,outro'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
        ];
    }
}
