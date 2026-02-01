<aside class="w-64 bg-white border-r shadow-sm flex flex-col">

    <!-- Brand -->
    <div class="h-16 flex items-center px-6 border-b">
        <span class="text-xl font-bold text-indigo-600 tracking-wide">
            {{ config('app.name') }}
        </span>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 py-6 space-y-1 text-sm font-medium">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg
                  text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
            <span>📊</span>
            <span>Dashboard</span>
        </a>

        @if(auth()->user()->company)

            <!-- Users -->
            <a href="{{ route('company.users.index', auth()->user()->company_id) }}"
               class="flex items-center gap-3 px-4 py-2 rounded-lg
                      text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                <span>👥</span>
                <span>Users</span>
            </a>

            <!-- Tasks -->
            <a href="{{ route('company.tasks.index', auth()->user()->company_id) }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg
                    text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                {{-- Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2-10H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2z" />
                </svg>
                {{-- Text --}}
                <span>Tasks</span>
            </a>

        @endif

    </nav>

    <!-- Footer -->
    <div class="px-6 py-4 border-t text-xs text-gray-500">
        Logged in as <br>
        <span class="font-medium text-gray-700">
            {{ auth()->user()->name }}
        </span>
    </div>

</aside>
