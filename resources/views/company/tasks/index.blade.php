@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">
                    Tasks
                </h1>
                <p class="text-sm opacity-90">
                    Manage tasks for {{ $company->name }}
                </p>
            </div>

            @can('create', [App\Models\Task::class, $company->id])
                <a href="{{ route('company.tasks.create', $company) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5
                          bg-white text-indigo-600 rounded-xl
                          font-medium shadow hover:scale-105 transition">
                    ➕ Create Task
                </a>
            @endcan
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200
                    text-green-700 rounded-xl">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <form method="GET" class="flex flex-wrap gap-3 items-center">
        <input type="text" name="title" placeholder="Search by title"
               value="{{ request('title') }}"
               class="border rounded-lg px-3 py-2 w-full md:w-64 focus:ring-1 focus:ring-blue-500">

        <select name="status" class="border rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500">
            <option value="">All Status</option>
            @foreach(['pending','in_progress','completed'] as $status)
                <option value="{{ $status }}" @selected(request('status') == $status)>
                    {{ ucfirst(str_replace('_',' ',$status)) }}
                </option>
            @endforeach
        </select>

        <select name="priority" class="border rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500">
            <option value="">All Priority</option>
            @foreach(['low','medium','high'] as $priority)
                <option value="{{ $priority }}" @selected(request('priority') == $priority)>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
            Filter
        </button>
    </form>

    <!-- Tasks Table -->
    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-xs uppercase tracking-wide text-gray-500">
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Priority</th>
                    <th class="px-6 py-4">Due Date</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @forelse($tasks as $task)
                <tr class="hover:bg-gray-50 transition">

                    <!-- Title -->
                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $task->title }}</td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'in_progress' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800'
                            ];
                        @endphp
                        <span class="inline-flex items-center gap-1 px-3 py-1
                                     text-xs font-medium rounded-full {{ $statusColors[$task->status] }}">
                            ● {{ ucfirst(str_replace('_',' ',$task->status)) }}
                        </span>
                    </td>

                    <!-- Priority -->
                    <td class="px-6 py-4">
                        @php
                            $priorityColors = [
                                'low' => 'bg-green-100 text-green-800',
                                'medium' => 'bg-yellow-100 text-yellow-800',
                                'high' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="inline-flex items-center gap-1 px-3 py-1
                                     text-xs font-medium rounded-full {{ $priorityColors[$task->priority] }}">
                            ● {{ ucfirst($task->priority) }}
                        </span>
                    </td>

                    <!-- Due Date -->
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        {{ $task->due_date?->format('d M, Y') ?? '-' }}
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        @can('update', $task)
                            <a href="{{ route('company.tasks.edit', [$company, $task]) }}"
                               class="px-2 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 transition text-sm">
                               Edit
                            </a>
                        @endcan

                        @can('delete', $task)
                            <form method="POST"
                                  action="{{ route('company.tasks.destroy', [$company, $task]) }}"
                                  onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200 transition text-sm">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-16 text-center text-gray-500">
                        No tasks added yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($tasks->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $tasks->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
