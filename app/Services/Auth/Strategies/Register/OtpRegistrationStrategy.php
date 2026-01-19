<?php

namespace App\Services\Auth\Strategies\Register;

use App\Models\Otp;
use App\Services\Auth\Contracts\RegistrationStrategyInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class OtpRegistrationStrategy implements RegistrationStrategyInterface
{
    /**
     * Register a new user after OTP verification.
     *
     * @return array{user: Model, token: string}
     *
     * @throws ValidationException
     */
    public function register(string $modelClass, array $credentials): array
    {
        $identifier = $credentials['email'] ?? $credentials['phone'];
        //TODO:: handle otp to service to verify otp , generate otp , increment attempts , expire otp etc.
        // TODO:: make a hashed otp serive
        $otp = Otp::where('identifier', $identifier)
            ->where('otpable_type', $modelClass)
            ->where('code', $credentials['otp'])
            ->active()
            ->forPurpose('registration')
            ->first();

        if (!$otp) {
            throw ValidationException::withMessages([
                'otp' => ['The provided OTP is invalid or has expired.'],
            ]);
        }

        // Check if OTP has too many attempts
        if ($otp->attempts >= 3) {
            throw ValidationException::withMessages([
                'otp' => ['Too many OTP attempts. Please request a new OTP.'],
            ]);
        }

        $otp->incrementAttempts();

        // verify expiration
        if ($otp->isExpired()) {
            throw ValidationException::withMessages([
                'otp' => ['The OTP has expired. Please request a new one.'],
            ]);
        }

        $user = $modelClass::create(array_merge($credentials, [
            'email_verified_at' => isset($credentials['email']) ? now() : null,
            'phone_verified_at' => isset($credentials['phone']) ? now() : null,
        ]));

        $otp->update([
            'otpable_id' => $user->id,
            'verified_at' => now(),
        ]);

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

}
