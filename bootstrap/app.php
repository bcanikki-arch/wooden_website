<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
     
          web: __DIR__.'/../routes/web.php',
            // then: function () {
            //     require base_path('routes/admin.php');
            // },
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->web(append: [
        //     \App\Http\Middleware\CheckAdminRole::class,
        // ]);

        $middleware->alias([
            // 'admin' => \App\Http\Middleware\CheckAdminRole::class,
              'admin' => \App\Http\Middleware\Admin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
