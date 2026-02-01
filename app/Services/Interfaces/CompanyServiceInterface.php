<?php

namespace App\Services\Interfaces;

use App\Models\Company;
use App\Models\User;

interface CompanyServiceInterface
{
    public function create(array $data): Company;

    public function find(int|string $id): Company;

    public function inviteUser(Company $company, array $data): User;

    public function activateUser(User $user): User;

    public function deactivateUser(User $user): User;
}
