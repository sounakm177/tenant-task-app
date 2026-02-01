<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\{
	UserRepositoryInterface,
    CompanyRepositoryInterface,
    PlanRepositoryInterface,
    TaskRepositoryInterface
};

use App\Repositories\{
	UserRepository,
    CompanyRepository,
    PlanRepository,
    TaskRepository
};

class RepositoryServiceProvider extends ServiceProvider
{

    public $bindings = [
		UserRepositoryInterface::class => UserRepository::class,
		CompanyRepositoryInterface::class => CompanyRepository::class,
		PlanRepositoryInterface::class => PlanRepository::class,
		TaskRepositoryInterface::class => TaskRepository::class,
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
