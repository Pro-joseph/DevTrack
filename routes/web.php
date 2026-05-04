<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
 Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        // Only authenticated users may enter...
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        // Uses first & second Middleware
    });

    Route::get('/dashboard', function () {
        // Uses first & second Middleware
    });
}); 

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/projects', function () {
    return view('projects.index');
})->middleware('auth')->name('projects.index');

