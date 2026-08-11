<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('program.manage');
    }

    public function rules(): array
    {
        return [
            'day_number' => ['required', 'integer', 'min:1'],
            'date' => ['nullable', 'date'],
            'title' => ['nullable', 'string', 'max:255'],
        ];
    }
}
