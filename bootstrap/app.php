<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if ($request->is('teacher*')) {
                return route('teacher.login');
            }
            if ($request->is('parent*')) {
                return route('parent.login');
            }
            return route('landing');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
