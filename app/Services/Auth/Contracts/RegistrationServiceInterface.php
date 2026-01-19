<?php

namespace App\Services\Auth\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RegistrationServiceInterface
{
    /**
     * Register a new user using the specified guard and registration method.
     *
     * @return array{user: Model, token: string}
     */
    public function register(string $guard, string $method, array $credentials): array;
}
