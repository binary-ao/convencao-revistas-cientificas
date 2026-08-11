<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['registration_id', 'code', 'type', 'status', 'pdf_path', 'issued_at', 'sent_at'];

    protected function casts(): array
    {
        return ['issued_at' => 'datetime', 'sent_at' => 'datetime'];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    /**
     * CERT-AO-{ano}-{sequência a 6 dígitos}, único por ano.
     */
    public static function generateCode(): string
    {
        $year = now()->year;
        $prefix = "CERT-AO-{$year}-";

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
