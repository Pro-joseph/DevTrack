<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Boot any application services.
     */
    public function boot(): void
    {
        Route::bind('task', function ($value) {
            return \App\Models\Task::withTrashed()->findOrFail($value);
        });
    }
}
