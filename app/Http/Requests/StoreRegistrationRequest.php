<?php

namespace App\Http\Requests;

use App\Models\ParticipantType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $outroTypeId = ParticipantType::where('code', 'outro')->value('id');

        return [
            // Etapa 1 — Dados pessoais
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'province' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],

            // Etapa 2 — Dados profissionais
            'institution_id' => ['nullable', 'exists:institutions,id'],
            'institution_name_other' => ['nullable', 'string', 'max:255'],
            'job_title' => ['required', 'string', 'max:255'],
            'scientific_area' => ['nullable', 'string', 'max:255'],

            // Etapa 3 — Perfil
            'participant_type_id' => ['required', 'exists:participant_types,id'],
            'participant_type_other' => [Rule::requiredIf($this->integer('participant_type_id') === $outroTypeId), 'nullable', 'string', 'max:255'],

            // Etapa 4 — Participação
            'modality' => ['required', 'in:presencial,online'],

            // Etapa 5 — Workshops/Cursos (só aplicável a presencial — todas as actividades são presenciais)
            'workshop_ids' => ['nullable', 'array'],
            'workshop_ids.*' => ['exists:workshops,id'],
            'course_ids' => ['nullable', 'array'],
            'course_ids.*' => ['exists:courses,id'],

            // Etapa 6 — Confirmação
            'privacy_policy' => ['accepted'],
            'confirm_data' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'O nome completo é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Introduza um endereço de email válido.',
            'phone.required' => 'O telefone é obrigatório.',
            'job_title.required' => 'O cargo/função é obrigatório.',
            'participant_type_id.required' => 'Seleccione o seu perfil.',
            'modality.required' => 'Seleccione a modalidade de participação.',
            'privacy_policy.accepted' => 'É necessário aceitar a Política de Privacidade.',
            'confirm_data.accepted' => 'Confirme que os dados fornecidos estão correctos.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workshop_ids' => $this->modality === 'online' ? [] : ($this->workshop_ids ?? []),
            'course_ids' => $this->modality === 'online' ? [] : ($this->course_ids ?? []),
        ]);
    }
}
