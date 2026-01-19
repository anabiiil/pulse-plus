<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEloquentRepository implements BaseRepositoryInterface
{
    /**
     * BaseEloquentRepository constructor with property promotion.
     */
    public function __construct(
        protected Model $model
    ) {}

    /**
     * Get all records.
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Find a record by ID.
     */
    public function find(int $id, array $columns = ['*']): ?Model
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find a record by ID or fail.
     */
    public function findOrFail(int $id, array $columns = ['*']): Model
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Find a record by specific field.
     */
    public function findBy(string $field, mixed $value, array $columns = ['*']): ?Model
    {
        return $this->model->where($field, $value)->first($columns);
    }

    /**
     * Get records with specific conditions.
     */
    public function findWhere(array $conditions, array $columns = ['*']): Collection
    {
        $query = $this->model->newQuery();

        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                [$field, $operator, $searchValue] = $value;
                $query->where($field, $operator, $searchValue);
            } else {
                $query->where($field, $value);
            }
        }

        return $query->get($columns);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a record by ID.
     */
    public function update(int $id, array $data): bool
    {
        $record = $this->find($id);

        if ($record) {
            return $record->update($data);
        }

        return false;
    }

    /**
     * Delete a record by ID.
     */
    public function delete(int $id): bool
    {
        $record = $this->find($id);

        if ($record) {
            return $record->delete();
        }

        return false;
    }

    /**
     * Paginate records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Get records with relationships.
     */
    public function with(array $relations): Collection
    {
        return $this->model->with($relations)->get();
    }
}
