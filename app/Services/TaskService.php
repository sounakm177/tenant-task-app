<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TaskService implements TaskServiceInterface
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function all(int $companyId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->taskRepository->query()
            ->where('company_id', $companyId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['title'])) {
            $query->where('title', 'like', "%{$filters['title']}%");
        }

        return $query->latest()->paginate($perPage);
    }

    public function find(int|string $id): Task
    {
        return $this->taskRepository->findOrFail($id);
    }

    public function create(array $data): Task
    {
        return DB::transaction(function () use ($data) {
            $company = auth()->user()->company;
            if(!$company->plan->hasUnlimitedTasks()){
                $taskCount = $company->tasks()->count();
                if ($taskCount >= $company->plan->task_limit) {
                    throw new \Exception("Your plan allows only {$company->plan->task_limit} tasks.");
                }
            }
            return $this->taskRepository->create($data);
        });
    }

    public function update(int|string $id, array $data): Task
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->taskRepository->update($id, $data);
        });
    }

    public function delete(int|string $id): bool
    {
        return DB::transaction(function () use ($id) {
            return $this->taskRepository->delete($id);
        });
    }
}
