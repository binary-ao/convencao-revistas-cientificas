<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('program.manage');
    }

    public function rules(): array
    {
        return [
            'event_day_id' => ['required', 'exists:event_days,id'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:opening,keynote,panel,roundtable,workshop,course,forum,break,lunch,debate,plenary,closing,other'],
            'room_location' => ['nullable', 'string', 'max:255'],
            'modality' => ['required', 'in:presencial,online,hibrido'],
            'workshop_id' => ['nullable', 'exists:workshops,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'moderator_speaker_id' => ['nullable', 'exists:speakers,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
