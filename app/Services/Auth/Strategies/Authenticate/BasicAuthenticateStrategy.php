<?php

namespace App\Services\Auth\Strategies\Authenticate;

use App\Services\Auth\Contracts\AuthenticateStrategyInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class BasicAuthenticateStrategy implements AuthenticateStrategyInterface
{
    /**
     * Register a new user with basic .
     *
     * @return array{user: Model, token: string}
     * @throws AuthenticationException
     */
    public function authenticate(string $modelClass, array $credentials): array
    {
        $authenticateBy = config('auth-strategies.authenticate_by');

        $user = $modelClass::where($authenticateBy, $credentials['identifier'])->first();

        // Check if user exists
        abort_unless($user, 401, 'Invalid credentials.');


        abort_unless($user->checkHashPassword($credentials['password']), 401, 'Invalid credentials.');

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
