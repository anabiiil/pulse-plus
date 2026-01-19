<?php

namespace App\Providers;

use App\Services\Auth\AuthenticateService;
use App\Services\Auth\Contracts\AuthenticateServiceInterface;
use App\Services\Auth\Contracts\RegistrationServiceInterface;
use App\Services\Auth\RegistrationService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind AuthenticateService interface to implementation
        $this->app->bind(
            AuthenticateServiceInterface::class,
            AuthenticateService::class

        );

        // Bind RegistrationService interface to implementation
        $this->app->bind(
            RegistrationServiceInterface::class,
            RegistrationService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
