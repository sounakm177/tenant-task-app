<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface RegistrationServiceInterface
{
    public function registerCompanyOwner(array $data): User;
}
