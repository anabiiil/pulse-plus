<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find user by email.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Get active users.
     */
    public function getActiveUsers(): Collection;

    /**
     * Update user password.
     */
    public function updatePassword(int $id, string $password): bool;
}
