<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\RegistrationServiceInterface;
use App\Services\Auth\Factories\ModelFactory;
use App\Services\Auth\Factories\RegistrationStrategyFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class RegistrationService implements RegistrationServiceInterface
{
    /**
     * Register a new user using the specified guard and registration method.
     *
     * @return array{user: Model, token: string}
     *
     * @throws InvalidArgumentException
     */
    public function register(string $guard, string $method, array $credentials): array
    {
        $modelClass = ModelFactory::resolveModel($guard);

        return RegistrationStrategyFactory::make($method)->register($modelClass, $credentials);
    }
}
