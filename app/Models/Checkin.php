<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'checked_in_at', 'checked_in_by_user_id', 'method', 'notes'];

    protected function casts(): array
    {
        return ['checked_in_at' => 'datetime'];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by_user_id');
    }
}
