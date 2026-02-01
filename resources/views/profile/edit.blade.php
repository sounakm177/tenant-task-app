@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow">
        <h1 class="text-2xl font-bold">Profile</h1>
        <p class="text-sm opacity-90">Manage your account settings</p>
    </div>

    <!-- Update Profile Information -->
    <div class="bg-white rounded-2xl shadow border overflow-hidden p-6">
        <h2 class="text-lg font-semibold mb-4">Update Profile Information</h2>
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Update Password -->
    <div class="bg-white rounded-2xl shadow border overflow-hidden p-6">
        <h2 class="text-lg font-semibold mb-4">Update Password</h2>
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete Account -->
    <div class="bg-white rounded-2xl shadow border overflow-hidden p-6">
        <h2 class="text-lg font-semibold mb-4">Delete Account</h2>
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection
