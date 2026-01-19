<?php

use App\Http\Middleware\CheckAdminAuth;
use App\Http\Middleware\CheckUserStatus;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        function (\Illuminate\Routing\Router $router) {
            $router->middleware('web')
                ->group(base_path('routes/web.php'));
            $router->middleware(['api', \App\Http\Middleware\ApiLanguageMiddleware::class])
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            $router->middleware('web')
                ->prefix('admin')
                ->as('admin.')
                ->group(base_path('routes/admin.php'));

            $router->middleware('web')
                ->prefix('dashboard')
                ->as('dashboard.')
                ->group(base_path('routes/dash.php'));

        },
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
//            'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
//            'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
//            'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
//            'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
//            'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'checkUserStatus' => CheckUserStatus::class,
            'checkAdmin' => CheckAdminAuth::class,
//            'auth' => \App\Http\Middleware\Authenticate::class,
//            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'doNotCacheResponse' => \Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class,
            'cacheResponse' => \Spatie\ResponseCache\Middlewares\CacheResponse::class,
            'varyCacheByLanguage' => \App\Http\Middleware\VaryCacheByLanguage::class,

        ]);

        $middleware->web(append: [
//            \Spatie\ResponseCache\Middlewares\CacheResponse::class,
        ]);

    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(
            guests: '/admin/login',
            users: '/admin'

        );
    })
//    ->withMiddleware(function (Middleware $middleware) {
//        $middleware->redirectTo(
//            guests: '/dash/login',
//            users: '/dash/index'
//
//        );
//    })
    ->withExceptions(function (Exceptions $exceptions) {

    })->create();

