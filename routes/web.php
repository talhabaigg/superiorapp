<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('project', ProjectController::class);
    Route::resource('users', UserController::class);

    // Route::get('/project/{project}/users', [ProjectUserController::class, 'index'])->name('project-users.index');
    Route::post('/projects/{project}/users', [ProjectUserController::class, 'store'])->name('project-users.store');
    Route::delete('/projects/{project}/users/{user}', [ProjectUserController::class, 'destroy'])->name('project-users.destroy');
    
    Route::get('/project-members/{project}', [ProjectUserController::class, 'index'])->name('project-users.index');
});

require __DIR__.'/auth.php';
