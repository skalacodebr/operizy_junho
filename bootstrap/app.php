<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        // commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware
        $middleware->append([
            // \App\Http\Middleware\TrustHosts::class,
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        // RouteMiddleware / Alias
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'XSS' => \App\Http\Middleware\XSS::class,
            'CheckPlan' => \App\Http\Middleware\CheckPlan::class,
            'customerauth' => \App\Http\Middleware\customerauth::class,
            'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
            'Lang' => \App\Http\Middleware\Lang::class,
            'DomainCheck' => \App\Http\Middleware\DomainRequest::class,
            'SetLocale' => \App\Http\Middleware\SetLocale::class,
            '2fa'=> \App\Http\Middleware\Google2fa::class,
        ]);

        // middlewareGroups / Group Middleware
        // Append middleware to the 'web' group
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \App\Http\Middleware\FilterRequest::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Append middleware to the 'api' group
        $middleware->appendToGroup('api', [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        
        // Exclude specific routes from CSRF protection
        $middleware->validateCsrfTokens(
            except: [
                'plan/paytm/*',
                'invoice/paytm/*',
                'paytm-payment-plan',
                'paymentwall-payment/*',
                '/planpayment',
                '*/order-pay-with-paymentwall',
                'iyzipay/callback/*',
                'paytab-success/*',
                '/aamarpay*'
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
