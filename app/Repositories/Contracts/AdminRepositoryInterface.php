<?php

namespace App\Repositories\Contracts;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Admin Repository Interface
 *
 * This interface defines the contract for admin-specific repository operations.
 * It extends the base repository interface and adds methods specific to admin management.
 *
 * @package App\Repositories\Contracts
 */
interface AdminRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find user by email.
     */
    public function findByEmail(string $email): ?Admin;

    /**
     * Get active users.
     */
    public function getActiveUsers(): Collection;

    /**
     * Update user password.
     */
    public function updatePassword(int $id, string $password): bool;
}
