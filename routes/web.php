<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Models\task;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/projects', function () {
        return view('projects.index');
    })->name('projects.index');

    Route::get('/project/new', function () {
        return view('project-form');
    })->name('projects.create');

    Route::post('/project/new', function () {
        return redirect()->route('projects.index');
    })->name('projects.store');

    Route::get('/project/{id}', function ($id) {
        return view('project_details');
    })->name('projects.show');

    Route::get('/project/{id}/edit', function ($id) {
        $project = (object) ['id' => $id, 'title' => '', 'description' => '', 'deadline' => '', 'status' => 'planning'];
        return view('project-form', compact('project'));
    })->name('projects.edit');

    Route::put('/project/{id}', function ($id) {
        return redirect()->route('projects.show', ['id' => $id]);
    })->name('projects.update');

    Route::get('/tasks', function () {
        return view('tasks.index');
    })->name('tasks.index');

    Route::get('/team', function () {
        return view('team.index');
    })->name('team.index');

    Route::get('/archives', function () {
        return view('archives.index');
    })->name('archives.index');

    Route::get('/task/new', function () {
        return view('edit');
    })->name('tasks.create');

    Route::post('/task/new', function () {
        return redirect()->route('projects.index');
    })->name('tasks.store');

    Route::get('/task/{id}/edit', function ($id) {
        $task = task::findOrFail($id);
        return view('edit', compact('task'));
    })->name('tasks.edit');

    Route::put('/task/{id}', function ($id) {
        return redirect()->route('projects.show', ['id' => $id]);
    })->name('tasks.update');
});