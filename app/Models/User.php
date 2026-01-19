<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Auth\HasCheckPassword;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens,HasCheckPassword;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'auth_type',
        'provider_id',
        'email_verified_at',
        'phone_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Scopes
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeByProvider($query, string $provider)
    {
        return $query->where('auth_provider', $provider);
    }

    public function isSocialUser(): bool
    {
        return in_array($this->auth_provider, ['google', 'facebook', 'apple']);
    }

    // Relationships
    public function otps(): MorphMany
    {
        return $this->morphMany(Otp::class, 'otpable');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


}
