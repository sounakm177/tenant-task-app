<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | Basic Reads
    |--------------------------------------------------------------------------
    */

    /**
     * Get all records.
     */
    public function all(
        array $columns = ['*'],
        array $relations = []
    ): Collection;

    /**
     * Find a record by primary key.
     */
    public function find(
        int|string $id,
        array $columns = ['*'],
        array $relations = []
    ): ?Model;

    /**
     * Find a record or fail.
     */
    public function findOrFail(
        int|string $id,
        array $columns = ['*'],
        array $relations = []
    ): Model;

    /**
     * Find first record matching conditions.
     */
    public function firstWhere(
        array $conditions,
        array $columns = ['*'],
        array $relations = []
    ): ?Model;

    /*
    |--------------------------------------------------------------------------
    | Writes
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new record.
     */
    public function create(array $data): Model;

    /**
     * Create or update a record.
     */
    public function update(
        int|string $id,
        array $data
    ): Model;

    /**
     * Delete a record by id.
     */
    public function delete(int|string $id): bool;

    /**
     * Delete records by conditions.
     */
    public function deleteWhere(array $conditions): int;

    /*
    |--------------------------------------------------------------------------
    | Bulk Operations
    |--------------------------------------------------------------------------
    */

    /**
     * Insert multiple records at once.
     */
    public function insert(array $records): bool;

    /**
     * Update multiple records.
     */
    public function updateWhere(
        array $conditions,
        array $data
    ): int;

    /*
    |--------------------------------------------------------------------------
    | Querying & Filtering
    |--------------------------------------------------------------------------
    */

    /**
     * Get records by conditions.
     */
    public function getWhere(
        array $conditions,
        array $columns = ['*'],
        array $relations = []
    ): Collection;

    /**
     * Check if any record exists.
     */
    public function exists(array $conditions): bool;

    /**
     * Count records.
     */
    public function count(array $conditions = []): int;

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    /**
     * Paginate results.
     */
    public function paginate(
        int $perPage = 15,
        array $conditions = [],
        array $columns = ['*'],
        array $relations = []
    ): LengthAwarePaginator;

    /*
    |--------------------------------------------------------------------------
    | Utility
    |--------------------------------------------------------------------------
    */

    /**
     * Get underlying model instance.
     * (use sparingly – mainly for advanced cases)
     */
    public function getModel(): Model;
}
