<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\AuthenticateServiceInterface;
use App\Services\Auth\Factories\AuthenticateStrategyFactory;
use App\Services\Auth\Factories\ModelFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AuthenticateService implements AuthenticateServiceInterface
{
    /**
     * Register a new user using the specified guard and registration method.
     *
     * @return array{user: Model, token: string}
     *
     * @throws InvalidArgumentException
     */
    public function authenticate(string $guard, string $method, array $credentials): array
    {
        $modelClass = ModelFactory::resolveModel($guard);

        return AuthenticateStrategyFactory::make($method)->authenticate($modelClass, $credentials);
    }
}
