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
        $middleware->web([
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\SetUserLocale::class,
            \App\Http\Middleware\SetCurrency::class,
            \App\Http\Middleware\SetSecurityHeaders::class,
            \App\Http\Middleware\TrackAffiliateClick::class,
        ]);
        
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'client.auth' => \App\Http\Middleware\ClientAuth::class,
            'site.access' => \App\Http\Middleware\CheckSiteAccess::class,
        ]);
        
        // Store client session data
        $middleware->append(\App\Http\Middleware\StoreClientSession::class);
        
        // Activity Log Middleware - لتسجيل جميع الأنشطة تلقائياً
        $middleware->append(\App\Http\Middleware\LogActivity::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
