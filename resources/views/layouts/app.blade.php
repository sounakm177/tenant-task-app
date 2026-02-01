<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen flex">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Main --}}
    <div class="flex-1 flex flex-col">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="p-6">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
