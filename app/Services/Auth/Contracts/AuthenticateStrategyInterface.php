<?php

namespace App\Services\Auth\Contracts;

use Illuminate\Database\Eloquent\Model;

interface AuthenticateStrategyInterface
{
    /**
     * Register a new user using the specified guard and registration method.
     *
     * @return array{user: Model, token: string}
     */
    public function authenticate(string $modelClass, array $credentials): array;
}
