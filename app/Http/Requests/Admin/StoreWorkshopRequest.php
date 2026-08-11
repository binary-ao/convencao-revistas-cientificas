<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkshopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('program.manage');
    }

    public function rules(): array
    {
        return [
            'code' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'trainer_speaker_id' => ['nullable', 'exists:speakers,id'],
            'date' => ['nullable', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:255'],
            'modality' => ['required', 'in:presencial,online'],
            'capacity' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
