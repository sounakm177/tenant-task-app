<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $user->company_id === $task->company_id || $user->isAdmin();
    }

    public function create(User $user, int $companyId): bool
    {
        return $user->company_id === $companyId || $user->isAdmin();
    }

    public function update(User $user, Task $task): bool
    {
        return $user->company_id === $task->company_id || $user->isAdmin();
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->company_id === $task->company_id || $user->isAdmin();
    }
}
