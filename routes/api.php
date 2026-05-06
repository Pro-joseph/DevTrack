<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

Route::apiResource('projects.tasks', TaskController::class);

