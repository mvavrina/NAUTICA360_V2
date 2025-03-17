<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Register API routes first
            Route::middleware(['web'])
                ->group(__DIR__.'/../routes/api.php');

            // Then register web routes
            Route::middleware(['web'])
                ->group(__DIR__.'/../routes/web.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Configure middleware as needed
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions as needed
    })
    ->create();
