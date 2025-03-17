<?php
// bootstrap/app.php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: __DIR__ . '/../routes/api.php', // Add API routing here
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register alias 'checkRole' for middleware CheckRole
        $middleware->alias([
            'checkRole' => CheckRole::class,


        ]);
        $middleware->append(StartSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
