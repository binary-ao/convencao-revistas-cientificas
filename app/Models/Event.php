<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'long_description',
        'start_date',
        'end_date',
        'venue_name',
        'address',
        'city',
        'country',
        'format',
        'contact_email',
        'contact_phone',
        'website_url',
        'logo_path',
        'favicon_path',
        'cover_image_path',
        'registration_open',
        'registration_opens_at',
        'registration_closes_at',
        'participant_limit',
        'status',
        'is_current',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'registration_open' => 'boolean',
            'registration_opens_at' => 'datetime',
            'registration_closes_at' => 'datetime',
            'is_current' => 'boolean',
        ];
    }

    public static function current(): ?self
    {
        return static::query()->where('is_current', true)->first();
    }

    public function days(): HasMany
    {
        return $this->hasMany(EventDay::class)->orderBy('day_number');
    }

    public function workshops(): HasMany
    {
        return $this->hasMany(Workshop::class)->orderBy('sort_order');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->orderBy('sort_order');
    }

    public function logoUrl(): ?string
    {
        return $this->logo_path ? Storage::disk('public')->url($this->logo_path) : null;
    }

    public function faviconUrl(): ?string
    {
        return $this->favicon_path ? Storage::disk('public')->url($this->favicon_path) : null;
    }

    public function coverImageUrl(): ?string
    {
        return $this->cover_image_path ? Storage::disk('public')->url($this->cover_image_path) : null;
    }
}
