<?php

namespace App\Models;

use App\Support\Enums\Otp\OTPStatusEnum;
use App\Support\Enums\Otp\OTPTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'expired_at', 'deleted_at', 'type', 'status'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OTPStatusEnum::class,
        'type' => OTPTypeEnum::class,
    ];

    protected $attributes = [
        'status' => OTPStatusEnum::ACTIVE,
    ];

    // Relations

    public function otpable(): MorphTo
    {
        return $this->morphTo();
    }
}
