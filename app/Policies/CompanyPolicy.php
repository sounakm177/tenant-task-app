<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;

class CompanyPolicy
{
    /**
     * Determine if the user can view company users.
     */
    public function view(User $user, Company $company): bool
    {
        // Only company members or admins can view
        return $user->company_id === $company->id || $user->isAdmin();
    }

    /**
     * Determine if the user can invite new users.
     */
    public function invite(User $user, Company $company): bool
    {
        // Only Company Owner can invite
        return $user->company_id === $company->id
            && $user->isCompanyOwner();
    }

    /**
     * Determine if the user can activate/deactivate users.
     */
    public function manageUsers(User $user, Company $company): bool
    {
        // Only Company Owner can manage users
        return $user->company_id === $company->id
            && $user->isCompanyOwner();
    }

    /**
     * Determine if the user can update company info.
     */
    public function update(User $user, Company $company): bool
    {
        return $user->company_id === $company->id
            && $user->isCompanyOwner();
    }

    /**
     * Determine if the user can delete the company.
     */
    public function delete(User $user, Company $company): bool
    {
        return $user->isAdmin(); // Only admin can delete
    }
}
