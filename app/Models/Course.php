<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'code', 'name', 'description', 'trainer_speaker_id',
        'date', 'start_time', 'end_time', 'room', 'modality', 'capacity',
        'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['date' => 'date', 'is_active' => 'boolean'];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Speaker::class, 'trainer_speaker_id');
    }

    public function registrations(): BelongsToMany
    {
        return $this->belongsToMany(Registration::class, 'registration_courses')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function registeredCount(): int
    {
        return $this->registrations()->wherePivot('status', 'registered')->count();
    }

    public function availableSpots(): int
    {
        return max(0, $this->capacity - $this->registeredCount());
    }

    public function isFull(): bool
    {
        return $this->availableSpots() <= 0;
    }
}
