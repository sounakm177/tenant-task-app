<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\{
    Task,
    User,
    Company
};

use App\Policies\{
    TaskPolicy,
    UserPolicy,
    CompanyPolicy
};

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Task::class => TaskPolicy::class,
        User::class => UserPolicy::class,
        Company::class => CompanyPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
