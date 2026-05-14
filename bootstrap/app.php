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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        
        // Ajout du middleware de redirection par défaut (remplace celui de Laravel)
        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();
            if ($user->role === 'admin') return '/admin/dashboard';
            if ($user->role === 'medecin') return '/medecin/dashboard';
            return '/patient/dashboard';
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();