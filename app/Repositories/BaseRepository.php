<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * The Eloquent model instance.
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /*
    |--------------------------------------------------------------------------
    | Core Query Builder
    |--------------------------------------------------------------------------
    */

    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    protected function applyConditions(
        Builder $query,
        array $conditions
    ): Builder {
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                // [operator, value]
                [$operator, $val] = $value;
                $query->where($field, $operator, $val);
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    protected function applyRelations(
        Builder $query,
        array $relations
    ): Builder {
        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Reads
    |--------------------------------------------------------------------------
    */

    public function all(
        array $columns = ['*'],
        array $relations = []
    ): Collection {
        return $this->applyRelations(
            $this->newQuery(),
            $relations
        )->get($columns);
    }

    public function find(
        int|string $id,
        array $columns = ['*'],
        array $relations = []
    ): ?Model {
        return $this->applyRelations(
            $this->newQuery(),
            $relations
        )->find($id, $columns);
    }

    public function findOrFail(
        int|string $id,
        array $columns = ['*'],
        array $relations = []
    ): Model {
        return $this->applyRelations(
            $this->newQuery(),
            $relations
        )->findOrFail($id, $columns);
    }

    public function firstWhere(
        array $conditions,
        array $columns = ['*'],
        array $relations = []
    ): ?Model {
        $query = $this->applyConditions(
            $this->newQuery(),
            $conditions
        );

        return $this->applyRelations($query, $relations)
            ->first($columns);
    }

    public function getWhere(
        array $conditions,
        array $columns = ['*'],
        array $relations = []
    ): Collection {
        $query = $this->applyConditions(
            $this->newQuery(),
            $conditions
        );

        return $this->applyRelations($query, $relations)
            ->get($columns);
    }

    public function exists(array $conditions): bool
    {
        return $this->applyConditions(
            $this->newQuery(),
            $conditions
        )->exists();
    }

    public function count(array $conditions = []): int
    {
        $query = $this->newQuery();

        if (! empty($conditions)) {
            $query = $this->applyConditions($query, $conditions);
        }

        return $query->count();
    }

    public function paginate(
        int $perPage = 15,
        array $conditions = [],
        array $columns = ['*'],
        array $relations = []
    ): LengthAwarePaginator {
        $query = $this->newQuery();

        if (! empty($conditions)) {
            $query = $this->applyConditions($query, $conditions);
        }

        $query = $this->applyRelations($query, $relations);

        return $query->paginate($perPage, $columns);
    }

    /*
    |--------------------------------------------------------------------------
    | Writes
    |--------------------------------------------------------------------------
    */

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(
        int|string $id,
        array $data
    ): Model {
        $record = $this->findOrFail($id);
        $record->fill($data);
        $record->save();

        return $record;
    }

    public function delete(int|string $id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    public function deleteWhere(array $conditions): int
    {
        return $this->applyConditions(
            $this->newQuery(),
            $conditions
        )->delete();
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Operations
    |--------------------------------------------------------------------------
    */

    public function insert(array $records): bool
    {
        return $this->model->newQuery()->insert($records);
    }

    public function updateWhere(
        array $conditions,
        array $data
    ): int {
        return $this->applyConditions(
            $this->newQuery(),
            $conditions
        )->update($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Utility
    |--------------------------------------------------------------------------
    */

    public function getModel(): Model
    {
        return $this->model;
    }

    /**
    * Return a new query builder instance.
    */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }
}
