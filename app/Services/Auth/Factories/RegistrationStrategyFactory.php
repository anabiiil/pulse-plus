<?php

namespace App\Services\Auth\Factories;

use App\Services\Auth\Contracts\RegistrationStrategyInterface;
use InvalidArgumentException;

class RegistrationStrategyFactory
{
    /**
     * Resolve and return the registration strategy based on the method.
     *
     * @throws InvalidArgumentException
     */
    public static function make(string $method): RegistrationStrategyInterface
    {
        $strategies = config('auth-strategies.methods.registration', []);

        if (! isset($strategies[$method])) {
            throw new InvalidArgumentException("Registration method [{$method}] is not supported.");
        }

        $strategyClass = $strategies[$method];

        if (! class_exists($strategyClass)) {
            throw new InvalidArgumentException("Strategy class [{$strategyClass}] does not exist.");
        }

        $strategy = app($strategyClass);

        if (! $strategy instanceof RegistrationStrategyInterface) {
            throw new InvalidArgumentException('Strategy class must implement RegistrationStrategyInterface.');
        }

        return $strategy;
    }
}
