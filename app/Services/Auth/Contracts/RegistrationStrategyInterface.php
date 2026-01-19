<?php

namespace App\Services\Auth\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RegistrationStrategyInterface
{
    /**
     * Register a new user with the given credentials.
     *
     * @return array{user: Model, token: string}
     */
    public function register(string $modelClass, array $credentials): array;
}
