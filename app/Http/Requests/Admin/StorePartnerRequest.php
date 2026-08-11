<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('partners.manage');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'website_url' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:1024'],
            'category' => ['required', 'in:ciencia_politica,edicao_indexacao,ciencia_aberta,africa_lusofonia'],
            'status' => ['required', 'in:proposto,convidado,confirmado,recusou'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
