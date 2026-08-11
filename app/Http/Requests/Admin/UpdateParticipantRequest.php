<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('participants.manage');
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'province' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'institution_id' => ['nullable', 'exists:institutions,id'],
            'institution_name_other' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'scientific_area' => ['nullable', 'string', 'max:255'],
            'participant_type_id' => ['required', 'exists:participant_types,id'],
            'participant_type_other' => ['nullable', 'string', 'max:255'],
        ];
    }
}
