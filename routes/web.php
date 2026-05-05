<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Models\task;
use App\Http\Controllers\ProjectController;


Route::middleware('auth')->group(function () {

    // Dashboard
    // CRUD Projets
    Route::resource('projects', ProjectController::class);

    // Actions spéciales
    Route::patch('projects/{id}/restore', [ProjectController::class, 'restore'])
         ->name('projects.restore');
});

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
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

    Route::get('/team', function () {
        return view('team.index');
    })->name('team.index');

    Route::get('/archives', function () {
        return view('archives.index');
    })->name('archives.index');

    Route::get('/task/new', [TaskController::class, 'create'])->name('tasks.create');

    Route::post('/task/new', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

    Route::put('/task/{id}', [TaskController::class, 'update'])->name('tasks.update');

    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});
