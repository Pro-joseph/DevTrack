<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Models\Project;
use App\Models\Task;
use App\Http\Controllers\ProjectController;


Route::middleware('auth')->group(function () {

    // Dashboard
    // CRUD Projets (excluding destroy since we use custom)
    Route::resource('projects', ProjectController::class)->except(['destroy']);

    // Actions spéciales
    Route::patch('projects/{id}/restore', [ProjectController::class, 'restore'])
        ->name('projects.restore');
    Route::post('projects/{id}/archive', [ProjectController::class, 'archive'])
        ->name('projects.archive');
    Route::delete('projects/{id}', [ProjectController::class, 'destroy'])
        ->name('projects.destroy');

    // Project Team Members
    Route::get('/projects/{project}/team', [App\Http\Controllers\TeamController::class, 'projectTeam'])
        ->name('projects.members.index');
});

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/dashboard', function () {
    $projects = Project::withoutGlobalScopes()
        ->with(['owner', 'members', 'tasks.user'])
        ->whereHas('members', fn($q) => $q->withoutGlobalScopes()->where('user_id', auth()->id()))
        ->whereNull('deleted_at')
        ->latest()
        ->get();

    $totalProjects = $projects->count();
    $activeProjects = $projects->where('status', '!=', 'archived')->count();
    $totalTasks = $projects->flatMap->tasks->count();

    return view('dashboard', compact('projects', 'totalProjects', 'activeProjects', 'totalTasks'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('/team', [App\Http\Controllers\TeamController::class, 'index'])->name('team.index');
    Route::post('/team/add-member', [App\Http\Controllers\TeamController::class, 'addMember'])
        ->name('team.addMember');
    Route::post('/team/remove-member', [App\Http\Controllers\TeamController::class, 'removeMember'])
        ->name('team.removeMember');

    Route::get('/archives', function () {
        $archivedProjects = Project::onlyTrashed()
            ->with(['owner', 'tasks'])
            ->latest()
            ->get();

        $archivedTasks = \App\Models\Task::onlyTrashed()
            ->with(['project', 'user'])
            ->latest()
            ->get();

        return view('archives.index', compact('archivedProjects', 'archivedTasks'));
    })->middleware(['auth'])->name('archives.index');

    Route::get('/task/new', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/project/{project}/task/new', [TaskController::class, 'create'])->name('tasks.create');

    Route::post('/task/new', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::get('/task/{id}', function ($id) {
        return redirect()->route('tasks.edit', $id);
    })->name('tasks.show');

    Route::put('/task/{id}', [TaskController::class, 'update'])->name('tasks.update');

    Route::match(['POST', 'PUT'], '/task/{id}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    Route::post('/task/{id}/archive', [TaskController::class, 'archive'])
        ->name('tasks.archive');

    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::patch('/task/{id}/restore', [TaskController::class, 'restore'])
        ->name('tasks.restore');
});
