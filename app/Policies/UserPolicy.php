<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Company owner can invite users
     */
    public function invite(User $user): bool
    {
        return $user->isOwner();
    }

    /**
     * Company owner can activate/deactivate users
     */
    public function updateStatus(User $user, User $targetUser): bool
    {
        return $user->isOwner()
            && $user->company_id === $targetUser->company_id;
    }
}
