<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = ['user_id', 'action', 'auditable_type', 'auditable_id', 'description', 'metadata', 'ip_address'];

    protected function casts(): array
    {
        return ['metadata' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, ?\Illuminate\Database\Eloquent\Model $subject = null, ?string $description = null, array $metadata = []): self
    {
        return static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'auditable_type' => $subject ? get_class($subject) : null,
            'auditable_id' => $subject?->getKey(),
            'description' => $description,
            'metadata' => $metadata ?: null,
            'ip_address' => request()->ip(),
        ]);
    }
}
