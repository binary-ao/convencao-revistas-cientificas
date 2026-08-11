<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'cover_image_path', 'author_id', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function coverImageUrl(): ?string
    {
        return $this->cover_image_path ? Storage::disk('public')->url($this->cover_image_path) : null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * "Publicado" imediato, ou "agendado" cuja data de publicação já passou.
     */
    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'publicado')
                ->orWhere(function ($q2) {
                    $q2->where('status', 'agendado')->where('published_at', '<=', now());
                });
        });
    }
}
