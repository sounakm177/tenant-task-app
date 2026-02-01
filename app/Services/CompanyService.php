<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\CompanyServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;

final class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}

    /**
     * Create a company.
     */
    public function create(array $data): Company
    {
        return DB::transaction(function () use ($data) {
            return $this->companyRepository->create($data);
        });
    }

    /**
     * Find a company by ID.
     */
    public function find(int|string $id): Company
    {
        return $this->companyRepository->findOrFail($id);
    }

    /**
     * Invite a user to the company.
     */
    public function inviteUser(Company $company, array $data): User
    {
        return DB::transaction(function () use ($company, $data) {

            return $this->userRepository->create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => Hash::make($data['password'] ?? str()->random(12)),
                'company_id' => $company->id,
                'role'       => UserRole::MEMBER,
                'active'     => true,
            ]);
        });
    }

    /**
     * Activate a company user.
     */
    public function activateUser(User $user): User
    {
        $user->update(['active' => true]);

        return $user;
    }

    /**
     * Deactivate a company user.
     */
    public function deactivateUser(User $user): User
    {
        $user->update(['active' => false]);

        return $user;
    }
}
