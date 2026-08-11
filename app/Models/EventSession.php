<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_day_id', 'start_time', 'end_time', 'title', 'description', 'type',
        'room_location', 'modality', 'workshop_id', 'course_id', 'moderator_speaker_id', 'sort_order',
    ];

    public function eventDay(): BelongsTo
    {
        return $this->belongsTo(EventDay::class);
    }

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(Speaker::class, 'moderator_speaker_id');
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'session_speakers')
            ->withPivot('role_in_session')
            ->withTimestamps();
    }
}
