<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface UserServiceInterface
{
    public function create(array $data): User;

    public function find(int|string $id): User;

    public function update(int|string $id, array $data): User;

    public function delete(int|string $id): bool;
}
