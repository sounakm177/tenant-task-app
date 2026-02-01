@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow">
        <h1 class="text-2xl font-bold">Create Task</h1>
        <p class="text-sm opacity-90 mt-1">Add a new task for {{ $company->name }}</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow p-6">

        <form method="POST" action="{{ route('company.tasks.store', $company) }}">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Title</label>
                <input type="text" name="title"
                       value="{{ old('title') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status, Priority, Due Date -->
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500">
                        @foreach(['pending','in_progress','completed'] as $status)
                            <option value="{{ $status }}" @selected(old('status')==$status)>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Priority</label>
                    <select name="priority" class="w-full border rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500">
                        @foreach(['low','medium','high'] as $priority)
                            <option value="{{ $priority }}" @selected(old('priority')==$priority)>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Due Date</label>
                    <input type="date" name="due_date"
                           value="{{ old('due_date') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            <!-- General Error Alert -->
            @if($errors->has('error'))
                <div class="my-4 p-3 bg-red-100 text-red-700 rounded">
                    ⚠️ {{ $errors->first('error') }}
                </div>
            @endif
            
            <!-- Buttons -->
            <div class="flex gap-3 mt-4">
                <button type="submit"
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-medium shadow hover:bg-indigo-700 transition">
                    Create Task
                </button>
                <a href="{{ route('company.tasks.index', $company) }}"
                   class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
