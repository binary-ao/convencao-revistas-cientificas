<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'category', 'file_path', 'original_filename',
        'status', 'event_id', 'uploaded_by_user_id', 'sort_order',
    ];

    public const CATEGORY_LABELS = [
        'programa' => 'Programa',
        'termo_referencia' => 'Termo de Referência',
        'regulamento' => 'Regulamento',
        'guias' => 'Guias',
        'oficiais' => 'Documentos Oficiais',
        'outros' => 'Outros',
    ];

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }

    public function fileUrl(): ?string
    {
        return $this->file_path ? Storage::disk('public')->url($this->file_path) : null;
    }
}
