<?php

namespace App\Services\Auth\Strategies\Register;

use App\Services\Auth\Contracts\RegistrationStrategyInterface;
use Illuminate\Database\Eloquent\Model;

class BasicRegistrationStrategy implements RegistrationStrategyInterface
{
    /**
     * Register a new user with basic credintaiols.
     *
     * @return array{user: Model, token: string}
     */
    public function register(string $modelClass, array $credentials): array
    {
        $user = $modelClass::create($credentials);
        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
