<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Dados da pessoa. Nunca tem password/login — a Convenção não cria contas
 * de participante (secção 4 da arquitectura). A inscrição em si vive em
 * Registration, separada de propósito.
 */
class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'email', 'phone', 'province', 'country',
        'institution_id', 'institution_name_other', 'job_title', 'scientific_area',
        'participant_type_id', 'participant_type_other', 'privacy_policy_accepted_at',
    ];

    protected function casts(): array
    {
        return ['privacy_policy_accepted_at' => 'datetime'];
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function participantType(): BelongsTo
    {
        return $this->belongsTo(ParticipantType::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
