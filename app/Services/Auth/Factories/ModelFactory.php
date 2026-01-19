<?php

namespace App\Services\Auth\Factories;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class ModelFactory
{
    /**
     * Resolve and return the model class based on the guard.
     *
     * @throws InvalidArgumentException
     */
    public static function resolveModel(string $guard): string
    {
        $guards = config('auth-strategies.guards', []);

        if (! isset($guards[$guard])) {
            throw new InvalidArgumentException("Guard [{$guard}] is not configured.");
        }

        $modelClass = $guards[$guard]['model'];

        if (! class_exists($modelClass)) {
            throw new InvalidArgumentException("Model class [{$modelClass}] does not exist.");
        }

        return $modelClass;
    }

    /**
     * Create a new instance of the model for the given guard.
     */
    public static function createModelInstance(string $guard): Model
    {
        $modelClass = self::resolveModel($guard);

        return new $modelClass;
    }
}
