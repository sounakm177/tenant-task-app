@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600
                rounded-2xl p-6 text-white shadow">
        <h1 class="text-2xl font-bold">
            Invite Team Member
        </h1>
        <p class="text-sm opacity-90">
            Add a new user to {{ $company->name }}
        </p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow border p-6">

        <form method="POST"
              action="{{ route('company.users.store', $company) }}"
              class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="John Doe"
                       class="w-full rounded-lg border-gray-300
                              focus:border-indigo-500 focus:ring-indigo-500
                              @error('name') border-red-500 @enderror">

                @error('name')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="user@company.com"
                       class="w-full rounded-lg border-gray-300
                              focus:border-indigo-500 focus:ring-indigo-500
                              @error('email') border-red-500 @enderror">

                @error('email')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-4 border-t">

                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-medium
                               bg-indigo-600 text-white
                               hover:bg-indigo-700 transition shadow">
                    Send Invite
                </button>

                <a href="{{ route('company.users.index', $company) }}"
                   class="px-6 py-2.5 rounded-xl text-sm font-medium
                          bg-gray-100 text-gray-700
                          hover:bg-gray-200 transition">
                    Cancel
                </a>

            </div>

        </form>
    </div>
</div>
@endsection
