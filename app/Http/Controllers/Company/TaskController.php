<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\TaskServiceInterface;
use App\Models\Company;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private TaskServiceInterface $taskService) {}

    public function index(Request $request, Company $company)
    {
        $this->authorize('view', $company);

        $tasks = $this->taskService->all(
            $company->id,
            $request->only(['status', 'priority', 'title'])
        );

        return view('company.tasks.index', compact('company', 'tasks'));
    }

    public function create(Company $company)
    {
        $this->authorize('create', [Task::class, $company->id]);

        return view('company.tasks.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        $this->authorize('create', [Task::class, $company->id]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $validated['company_id'] = $company->id;

        try {
            $this->taskService->create($validated);
            return redirect()->route('company.tasks.index', $company)
                            ->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Company $company, Task $task)
    {
        $this->authorize('update', $task);

        return view('company.tasks.edit', compact('company', 'task'));
    }

    public function update(Request $request, Company $company, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $this->taskService->update($task->id, $validated);

        return redirect()->route('company.tasks.index', $company)
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Company $company, Task $task)
    {
        $this->authorize('delete', $task);

        $this->taskService->delete($task->id);

        return redirect()->route('company.tasks.index', $company)
            ->with('success', 'Task deleted successfully.');
    }
}
