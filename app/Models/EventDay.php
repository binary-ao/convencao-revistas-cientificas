<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventDay extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'day_number', 'date', 'title'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(EventSession::class)->orderBy('sort_order')->orderBy('start_time');
    }
}
