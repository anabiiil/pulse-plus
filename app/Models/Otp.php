<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Otp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'otpable_type',
        'otpable_id',
        'code',
        'channel',
        'purpose',
        'expires_at',
        'verified_at',
        'attempts',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'attempts' => 'integer',
    ];

    /**
     * Get the parent otpable model (User or Admin).
     */
    public function otpable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if the OTP is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the OTP is verified.
     */
    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    /**
     * Mark the OTP as verified.
     */
    public function markAsVerified(): bool
    {
        return $this->update(['verified_at' => now()]);
    }

    /**
     * Increment failed attempts.
     */
    public function incrementAttempts(): bool
    {
        return $this->increment('attempts');
    }

    /**
     * Scope a query to only include active (not expired and not verified) OTPs.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('verified_at')
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope a query to filter by purpose.
     */
    public function scopeForPurpose($query, string $purpose)
    {
        return $query->where('purpose', $purpose);
    }

    /**
     * Scope a query to filter by channel.
     */
    public function scopeForChannel($query, string $channel)
    {
        return $query->where('channel', $channel);
    }
}

