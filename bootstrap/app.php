<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'AbleCreateOrder' => \App\Http\Middleware\AbleCreateOrder::class,
            'AbleFinishOrder' => \App\Http\Middleware\AbleFinishOrder::class,
            'AbleCreateUser' => \App\Http\Middleware\AbleCreateUser::class,
            'AbleCreateUpdateItem' => \App\Http\Middleware\AbleCreateUpdateItem::class,
            'AblePayOrder' => \App\Http\Middleware\AblePayOrder::class,
            'AbleSeeReport' => \App\Http\Middleware\AbleSeeReport::class,
            'AdminPanelProvider' => \App\Http\Middleware\AdminPanelAuthenticate::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
