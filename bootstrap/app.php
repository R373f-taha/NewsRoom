<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LogApiRequest;
use App\Http\Middleware\SecurityMiddleware;
use App\Http\Middleware\WriterMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
       InvokeDeferredCallbacks::class,
       LogApiRequest::class,
       SecurityMiddleware::class
    ]);
       $middleware->alias([
        'is_admin' => AdminMiddleware::class,
        'is_writer' =>WriterMiddleware::class,
    ]);


    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();



