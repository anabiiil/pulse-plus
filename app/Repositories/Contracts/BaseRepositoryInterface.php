<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Get all records.
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Find a record by ID.
     */
    public function find(int $id, array $columns = ['*']): ?Model;

    /**
     * Find a record by ID or fail.
     */
    public function findOrFail(int $id, array $columns = ['*']): Model;

    /**
     * Find a record by specific field.
     */
    public function findBy(string $field, mixed $value, array $columns = ['*']): ?Model;

    /**
     * Get records with specific conditions.
     */
    public function findWhere(array $conditions, array $columns = ['*']): Collection;

    /**
     * Create a new record.
     */
    public function create(array $data): Model;

    /**
     * Update a record by ID.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a record by ID.
     */
    public function delete(int $id): bool;

    /**
     * Paginate records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*']);

    /**
     * Get records with relationships.
     */
    public function with(array $relations): Collection;
}

