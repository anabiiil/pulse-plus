<?php

namespace App\Services\Auth\Factories;

use App\Services\Auth\Contracts\AuthenticateStrategyInterface;
use InvalidArgumentException;

class AuthenticateStrategyFactory
{
    /**
     * Resolve and return the authentication strategy based on the method.
     *
     * @throws InvalidArgumentException
     */
    public static function make(string $method): AuthenticateStrategyInterface
    {
        $strategies = config('auth-strategies.methods.authenticate', []);

        if (! isset($strategies[$method])) {
            throw new InvalidArgumentException("Authentication method [{$method}] is not supported.");
        }

        $strategyClass = $strategies[$method];

        if (! class_exists($strategyClass)) {
            throw new InvalidArgumentException("Strategy class [{$strategyClass}] does not exist.");
        }

        $strategy = app($strategyClass);

        if (! $strategy instanceof AuthenticateStrategyInterface) {
            throw new InvalidArgumentException('Strategy class must implement AuthenticateStrategyInterface.');
        }

        return $strategy;
    }
}
