<?php

namespace App\Support\Traits\Models;


use App\Models\Otp;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasOtp
{

    public function otps(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Otp::class, 'otpable');
    }

    public function last_otp(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable')->latest();
    }


    public function last_forget_otp(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable')->where('type', 'forget')->latest();
    }
}
