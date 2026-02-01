@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">
                    Team Members
                </h1>
                <p class="text-sm opacity-90">
                    Manage users for {{ $company->name }}
                </p>
            </div>

            @can('invite', $company)
                <a href="{{ route('company.users.create', $company) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5
                          bg-white text-indigo-600 rounded-xl
                          font-medium shadow hover:scale-105 transition">
                    ➕ Invite User
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

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-xs uppercase tracking-wide text-gray-500">
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
            @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition">

                    <!-- User Info -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100
                                        text-indigo-600 flex items-center justify-center
                                        font-semibold uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>

                            <div>
                                <div class="font-semibold text-gray-800">
                                    {{ $user->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{$user->role}}
                                </div>
                            </div>
                        </div>
                    </td>

                    <!-- Email -->
                    <td class="px-6 py-4 text-gray-600 text-sm">
                        {{ $user->email }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        @if($user->active)
                            <span class="inline-flex items-center gap-1 px-3 py-1
                                         text-xs font-medium rounded-full
                                         bg-green-100 text-green-700">
                                ● Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1
                                         text-xs font-medium rounded-full
                                         bg-red-100 text-red-700">
                                ● Inactive
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-right">
                        @can('manageUsers', $company)
                            <button
                                class="toggle-user-status text-sm {{ $user->active ? 'text-yellow-700' : 'text-green-700' }} hover:underline"
                                data-user-id="{{ $user->id }}"
                                data-company-id="{{ $company->id }}"
                                data-action="{{ $user->active ? 'deactivate' : 'activate' }}">
                                {{ $user->active ? 'Deactivate' : 'Activate' }}
                            </button>
                        @endcan
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-16 text-center text-gray-500">
                        No users added yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $users->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
