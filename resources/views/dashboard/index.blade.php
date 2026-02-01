@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- Page Title --}}
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">
            Dashboard
        </h1>
        <p class="text-sm text-gray-500">
            Overview of your account & subscription
        </p>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Company Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <!-- Building Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 21h18M9 8h6M10 12h4M4 21V3h16v18" />
                    </svg>
                </div>

                <div>
                    <h3 class="text-sm text-gray-500">Company</h3>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ auth()->user()->company->name }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Subscription Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <!-- Credit Card Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2 8h20M2 12h20M6 16h4M2 6a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                    </svg>
                </div>

                <div>
                    <h3 class="text-sm text-gray-500">Subscription</h3>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ auth()->user()->company->plan->name }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Role Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <!-- User Shield Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 3l8 4v5c0 5-3.5 9-8 9s-8-4-8-9V7l8-4z" />
                    </svg>
                </div>

                <div>
                    <h3 class="text-sm text-gray-500">Role</h3>
                    <p class="text-lg font-semibold text-gray-800 capitalize">
                        {{ auth()->user()->role }}
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
