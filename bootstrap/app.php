<?php

use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \Dyrynda\Database\LaravelEfficientUuidServiceProvider::class,
        \SocialiteProviders\Manager\ServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(AppServiceProvider::HOME);

        $middleware->validateCsrfTokens(except: [
            'login/constantcontact/callback',
            'testimonials',
            'content-page/*/upload',
            'horizon/*',
        ]);

        $middleware->throttleWithRedis();

        $middleware->web([
            \Laravel\Jetstream\Http\Middleware\AuthenticateSession::class,
            \App\Http\Middleware\Localization::class,
        ]);

        $middleware->throttleApi();

        $middleware->replace(\Illuminate\Http\Middleware\TrustProxies::class, \App\Http\Middleware\TrustProxies::class);

        $middleware->alias([
            'ai-download' => \App\Http\Middleware\DownloadAIExperienceMiddleware::class,
            'api-terms' => \App\Http\Middleware\RequireApiTermsAcceptanceMiddleware::class,
            'honeypot' => \Spatie\Honeypot\ProtectAgainstSpam::class,
            'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
