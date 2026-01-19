<?php

namespace App\Support\Repositories;

use App\Contracts\DB\EloquentRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentMainRepository implements EloquentRepositoryInterface
{
    protected Model $model;

    protected Builder $query;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $model->query();
    }

    public function builder(array $cols = ['*'], array $relations = [], array $condition = [], string $order = 'desc', string $orderCol = 'id', $orderByRaw = null,array $localScopes = []): Builder
    {

        $query = $this->model::with($relations)->where($condition)->select($cols);
        foreach ($localScopes as $scope) {
            $query = $query->{$scope}();
        }

        if (! $orderByRaw) {
            $query = $query->orderBy($orderCol, $order);
        } else {
            $query = $query->orderByRaw($orderByRaw);
        }

        // dd($query , Transaction::get());
        return $query;

    }


    public function paginate(array $cols = ['*'], array $relations = [], array $condition = [], string $order = 'asc', string $orderCol = 'id', ?int $paginate = 10,array $localScopes = []): LengthAwarePaginator
    {
        return $this->builder($cols, $relations, $condition, $order, $orderCol,localScopes: $localScopes)->paginate($paginate ?? 10);
    }

    public function cursorPaginate(array $cols = ['*'], array $relations = [], array $condition = [], string $order = 'desc', string $orderCol = 'id', ?int $paginate = 10, $orderByRaw = null,array $localScopes = []): CursorPaginator
    {
        return $this->builder($cols, $relations, $condition, $order, $orderCol, $orderByRaw)->cursorPaginate($paginate ?? 10);
    }

    public function all(array $cols = ['*'], array $relations = [], array $condition = [], string $order = 'asc', string $orderCol = 'id', $orderByRaw = null,array $localScopes = []): Collection
    {
        return $this->builder($cols, $relations, $condition, $order, $orderCol, $orderByRaw)->get();
    }

    public function store(array $data): ?Model
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data): ?Model
    {
        $team = $this->findByCols(['id' => $id]);
        $team->update($data);

        return $team;
    }

    public function updateWithReturn(int $id, array $data): ?Model
    {
        $team = $this->findByCols(['id' => $id]);

        return tap($team)->update($data);

    }

    public function findByCols(array $cols, array $with = [], array $select = ['*'], $orderBy = 'asc'): ?Model
    {
        return $this->model::with($with)->select($select)->where($cols)->orderBy('id', $orderBy)->first();
    }

    public function find(array $conditions, array $cols = ['*']): ?Model
    {

        return $this->model::select($cols)->where($conditions)->first();
    }

    public function destroy(int $id): bool
    {
        return $this->model::find($id)->delete();
    }

    public function updateOrCreate(array $find, array $data): Model
    {
        return $this->model::updateOrCreate($find, $data);
    }
    public function getByKey($column, $data): collection
    {
        return $this->query->whereIn($column, (array)$data)->get();
    }
    public function findByKey($column, $value): Model
    {
        return $this->query->where($column, $value)->first();
    }
    public function whereHas($relation, $callback): Builder
    {
        return $this->query->whereHas($relation, $callback);
    }

}
