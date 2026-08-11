<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'participant_id', 'code', 'status', 'modality',
        'submitted_at', 'confirmed_at', 'cancelled_at', 'cancellation_reason',
        'payment_status', 'payment_reference', 'payment_method', 'payment_amount', 'paid_at',
        'pdf_path', 'pdf_generated_at', 'qr_code_value',
        'checkin_status', 'certificate_status',
        'source', 'admin_notes', 'created_by_user_id', 'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'paid_at' => 'datetime',
            'pdf_generated_at' => 'datetime',
            'payment_amount' => 'decimal:2',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function workshops(): BelongsToMany
    {
        return $this->belongsToMany(Workshop::class, 'registration_workshops')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'registration_courses')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    public function checkin(): HasOne
    {
        return $this->hasOne(Checkin::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    /**
     * CNRC-AO-{ano}-{sequência a 6 dígitos}, único por evento/ano.
     * Sequência calculada dentro de uma transacção com lock para evitar
     * colisão sob submissões concorrentes.
     */
    public static function generateCode(Event $event): string
    {
        $year = now()->year;
        $prefix = "CNRC-AO-{$year}-";

        return DB::transaction(function () use ($prefix) {
            $last = static::where('code', 'like', "{$prefix}%")
                ->lockForUpdate()
                ->orderByDesc('code')
                ->value('code');

            $nextSequence = $last ? ((int) substr($last, -6)) + 1 : 1;

            return $prefix.str_pad((string) $nextSequence, 6, '0', STR_PAD_LEFT);
        });
    }
}
