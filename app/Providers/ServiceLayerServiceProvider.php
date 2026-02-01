<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Interfaces\{
	UserServiceInterface,
    CompanyServiceInterface,
    AuthServiceInterface,
    RegistrationServiceInterface,
    TaskServiceInterface
};

use App\Services\{
    UserService,
    CompanyService,
    AuthService,
    RegistrationService,
    TaskService
};

class ServiceLayerServiceProvider extends ServiceProvider
{

    public $bindings = [
        UserServiceInterface::class => UserService::class,
        AuthServiceInterface::class => AuthService::class,
        RegistrationServiceInterface::class => RegistrationService::class,
        CompanyServiceInterface::class => CompanyService::class,
        TaskServiceInterface::class => TaskService::class,
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
        //
    }
}
