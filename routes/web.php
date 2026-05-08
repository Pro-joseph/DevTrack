<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
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
    Route::patch('projects/{project}/restore', [ProjectController::class, 'restore'])
        ->name('projects.restore');
    Route::post('projects/{project}/archive', [ProjectController::class, 'archive'])
        ->name('projects.archive');
    Route::delete('projects/{project}/force-delete', function (Project $project) {
        $project->forceDelete();
        return redirect()->route('projects.index')->with('success', 'Projet supprimé définitivement !');
    })->name('projects.force-delete')
      ->middleware('auth')
      ->withTrashed();

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
            ->with(['project', 'user', 'assignee'])
            ->whereHas('project', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->latest()
            ->get();

        return view('archives.index', compact('archivedProjects', 'archivedTasks'));
    })->middleware(['auth'])->name('archives.index');

    Route::get('/project/{project}/task/new', [TaskController::class, 'create'])->name('tasks.create');

    Route::post('/project/{project}/task/new', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/project/{project}/task/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::get('/project/{project}/task/{task}', function ($project, $task) {
        return redirect()->route('tasks.edit', [$project, $task]);
    })->name('tasks.show');

    Route::put('/project/{project}/task/{task}', [TaskController::class, 'update'])->name('tasks.update');

    Route::match(['POST', 'PUT'], '/project/{project}/task/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    Route::delete('/project/{project}/task/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::patch('/project/{project}/task/{task}/restore', [TaskController::class, 'restore'])
        ->name('tasks.restore');

    Route::patch('/task/{task}/restore', function (\App\Models\Task $task) {
        $task->restore();
        return redirect()->back()->with('success', 'Tâche restaurée !');
    })->name('tasks.restore-simple');

    Route::delete('/task/{task}/permanent', function (\App\Models\Task $task) {
        Gate::authorize('forceDelete', $task);
        $task->forceDelete();
        return redirect()->back()->with('success', 'Tâche supprimée définitivement !');
    })->name('tasks.force-delete');

    Route::delete('/task/{task}', function (\App\Models\Task $task) {
        Gate::authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée !');
    })->name('tasks.destroy-simple');
});