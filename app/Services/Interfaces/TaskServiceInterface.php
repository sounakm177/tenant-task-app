<?php

namespace App\Services\Interfaces;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskServiceInterface
{
    public function all(int $companyId, array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function find(int|string $id): Task;
    public function create(array $data): Task;
    public function update(int|string $id, array $data): Task;
    public function delete(int|string $id): bool;
}
