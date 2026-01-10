<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            // Authentication & Authorization Middleware
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,

            // Localization Middleware
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,

            // Can Login Middleware
            'can_login' => \App\Http\Middleware\can_login::class,
            'can_login_merchants' => \App\Http\Middleware\can_login_merchants::class,

            // Can Login Clients Middleware
            'can_login_clients' => \App\Http\Middleware\can_login_clients::class,

            // XSS Middleware
            'xss' => \App\Http\Middleware\XSS::class,

            // User Authentication Middleware
            'user.auth' => \App\Http\Middleware\RedirectIfNotUser::class,

            // Merchant Authentication Middleware
            'merchant.auth' => \App\Http\Middleware\RedirectIfNotMerchant::class,

            // Client Authentication Middleware
            'client.auth' => \App\Http\Middleware\RedirectIfNotClient::class,

        ]);

        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        //
    })
    ->withProviders([
        App\Providers\RepositoryServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
