<?php

use App\Http\Controllers\AbsentController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\PrestartController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\BuildingTaskController;
use App\Http\Controllers\CostcodeController;
use App\Http\Controllers\PrestartSignedController;
use App\Http\Controllers\PageController;

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
    Route::get('project-members/{project}/edit', [ProjectUserController::class, 'edit'])->name('project-users.edit');

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
    
    //Manage Personal timesheets
    // Route::get('/time-sheets/edit', [TimesheetController::class, 'weeklyEdit'])->name('timesheet.edit');
    Route::get('/time-sheets/{id}/{weekEnding}', [TimesheetController::class, 'weeklyEdit'])->name('timesheet.edit');

    //Manage Personal timesheets
    Route::get('/time-sheets/{id}/{date}/manage', [TimesheetController::class, 'showTimesheet'])->name('timesheets.show');
    Route::get('/timesheet/approve/{date}/{userId}', [TimesheetController::class, 'toggleApproval'])->name('timesheet.approve');
    // Prestart management
    Route::resource('daily-prestarts', PrestartController::class);
    Route::get('daily-prestarts/{prestart}/duplicate', [PrestartController::class, 'duplicate'])->name('daily-prestarts.duplicate');
    Route::get('/daily-prestarts/{prestart}/sign-sheet-template', [PrestartController::class, 'signsheetTemplate'])->name('daily-prestarts.signsheet-template');
    Route::get('/daily-prestarts/{prestart}/pdf', [PrestartController::class, 'prestartPdf'])->name('daily-prestarts.pdf');

    Route::get('/daily-prestart-signed/{prestart}/file', [PrestartController::class, 'uploadSignedPagesPDF'])->name('daily-prestart-signed.uploadpdf');
    Route::post('/prestart-signed/save', [PrestartSignedController::class, 'save'])->name('prestart-signed.save');

    //Absentee management
    Route::get('/absent/{prestart}/manage', [AbsentController::class, 'manage'])->name('absentee.manage');
    Route::post('/prestart/absentees/store', [AbsentController::class, 'store'])->name('prestart.absentees.store');
    Route::get('/absent', [AbsentController::class, 'index'])->name('absentee.index');

    //Admin
    Route::resource('cost-codes', CostcodeController::class);
   
    Route::get('/costcodes/upload', [CostcodeController::class, 'showUploadForm'])->name('cost-codes.upload');
    Route::post('/cost-codes/import', [CostcodeController::class, 'import'])->name('cost-codes.import');

});

Route::fallback([PageController::class, 'notfound'])->where('catchall', '.*');
// Authentication routes
require __DIR__.'/auth.php';
