<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Company\UserController;
use App\Http\Controllers\Company\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Company scoped routes (TENANT)
|--------------------------------------------------------------------------
*/
Route::prefix('companies/{company}')
    ->middleware(['auth', 'tenant'])
    ->group(function () {

        Route::get('/users', [UserController::class, 'index'])
            ->name('company.users.index');

        Route::get('/users/create', [UserController::class, 'create'])
            ->name('company.users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->name('company.users.store');

        Route::patch('/users/{user}/activate', [UserController::class, 'activate'])
            ->name('company.users.activate');

        Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])
            ->name('company.users.deactivate');

        Route::resource('tasks', TaskController::class)
            ->names('company.tasks');
    });

require __DIR__.'/auth.php';
