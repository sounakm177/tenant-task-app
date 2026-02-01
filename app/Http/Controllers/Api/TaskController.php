<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Http\Requests\Api\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct(private TaskServiceInterface $taskService)
    {}

    // LIST + FILTER
    public function index(Request $request)
    {
        $companyId = $request->user()->company_id;

        $tasks = $this->taskService->all(
            $companyId,
            $request->only(['status', 'priority', 'title'])
        );

        return TaskResource::collection($tasks)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    // CREATE
    public function store(StoreTaskRequest $request)
    {
        try {
            $task = $this->taskService->create([
                ...$request->validated(),
                'company_id' => $request->user()->company_id,
            ]);
            return (new TaskResource($task))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'error' => $e->getMessage()], 500);
        }
    }

    // SHOW
    public function show(int $id)
    {
        $task = $this->taskService->find($id);

        $this->authorize('view', $task);

        return new TaskResource($task);
    }

    // UPDATE
    public function update(UpdateTaskRequest $request, int $id)
    {
        $task = $this->taskService->find($id);

        $this->authorize('update', $task);

        $task = $this->taskService->update($id, $request->validated());

        return new TaskResource($task);
    }

    // DELETE
    public function destroy(int $id)
    {
        $task = $this->taskService->find($id);

        $this->authorize('delete', $task);

        $this->taskService->delete($id);

        return response()->json([
            'message' => 'Task deleted successfully'
        ], Response::HTTP_OK);
    }
}
