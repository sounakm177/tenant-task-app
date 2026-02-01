<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;
use App\Services\Interfaces\{
    RegistrationServiceInterface,
    UserServiceInterface,
    CompanyServiceInterface,
};
use App\Repositories\Interfaces\PlanRepositoryInterface;

final class RegistrationService implements RegistrationServiceInterface
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly CompanyServiceInterface $companyService,
        private readonly PlanRepositoryInterface $planRepository
    ) {}

    public function registerCompanyOwner(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $freePlan = $this->planRepository->firstWhere([
                'code' => 'free',
            ]);

            $company = $this->companyService->create([
                'name'    => $data['company_name'],
                'status'  => true,
                'plan_id' => $freePlan->id,
            ]);

            $user = $this->userService->create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'password'   => $data['password'],
                'company_id' => $company->id,
                'role'       => UserRole::OWNER,
            ]);

            Auth::login($user);

            return $user;
        });
    }
}
