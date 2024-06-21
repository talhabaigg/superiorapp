<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\BuildingTaskController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\TimesheetController;

// Public routes
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

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Project management
    Route::resource('project', ProjectController::class);

    // User management
    Route::resource('users', UserController::class);

    // Project-User management
    Route::post('/projects/{project}/users', [ProjectUserController::class, 'store'])->name('project-users.store');
    Route::delete('/projects/{project}/users/{user}', [ProjectUserController::class, 'destroy'])->name('project-users.destroy');
    Route::get('/project-members/{project}', [ProjectUserController::class, 'index'])->name('project-users.index');

    // Building management within projects
    Route::get('projects/{project}/buildings', [BuildingController::class, 'index'])->name('buildings.index');
    Route::post('projects/{project}/buildings', [BuildingController::class, 'store'])->name('buildings.store');

    // Building tasks management
    Route::get('projects/{project}/buildings/{building}/tasks/create', [BuildingTaskController::class, 'create'])->name('buildingtask.create');
    Route::post('projects/{project}/buildings/{building}/tasks', [BuildingTaskController::class, 'store'])->name('buildingtasks.store');
    Route::get('projects/tasks/{id}/toggle', [BuildingTaskController::class, 'toggleCompletion'])->name('buildingtask.toggle');

    // Timesheet management
    Route::get('/time-sheets/create', [TimesheetController::class, 'create'])->name('timesheet.create');
    Route::post('/time-sheets/create', [TimesheetController::class, 'store'])->name('timesheet.store');
    Route::get('/time-sheets', [TimesheetController::class, 'index'])->name('timesheet.index');
});

// Authentication routes
require __DIR__.'/auth.php';
