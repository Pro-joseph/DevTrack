<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('projects.tasks', TaskController::class)
     ->only(['index', 'show']);