<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            return $this->userRepository->create($data);
        });
    }

    public function find(int|string $id): User
    {
        return $this->userRepository->findOrFail($id);
    }

    public function update(int|string $id, array $data): User
    {
        return DB::transaction(function () use ($id, $data) {

            if (isset($data['password']) && $data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            return $this->userRepository->update($id, $data);
        });
    }

    public function delete(int|string $id): bool
    {
        return DB::transaction(function () use ($id) {
            $this->userRepository->findOrFail($id);
            return $this->userRepository->delete($id);
        });
    }
}
