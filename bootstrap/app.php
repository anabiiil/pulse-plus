<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api/admin')
                ->middleware('api')
                ->group(base_path('routes/admin-api.php'));

            Route::prefix('api/user')
                ->middleware('api')
                ->group(base_path('routes/user-api.php'));

            Route::prefix('api/vendor')
                ->middleware('api')
                ->group(base_path('routes/vendor-api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
