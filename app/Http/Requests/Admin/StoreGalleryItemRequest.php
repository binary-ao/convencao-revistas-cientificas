<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGalleryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('content.manage');
    }

    public function rules(): array
    {
        return [
            'gallery_album_id' => ['required', 'exists:gallery_albums,id'],
            'type' => ['required', 'in:photo,video'],
            'file' => [Rule::requiredIf($this->input('type') === 'photo'), 'nullable', 'image', 'max:4096'],
            'video_url' => [Rule::requiredIf($this->input('type') === 'video'), 'nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
