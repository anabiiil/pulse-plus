<?php

namespace App\Providers;

use App\Events\Auth\UserRegistered;
use App\Listeners\Auth\SendWelcomeEmail;
use App\Models\Meal;
use App\Models\PlanNutrition;
use App\Observers\AgencyObserver;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Laravel\Socialite\Contracts\Factory as SocialiteFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageManager::class, function ($app) {
            return new ImageManager(new Driver());
        });
    }

    /**
     * Bootstrap any application services.
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        // Register observers
        PlanNutrition::observe(AgencyObserver::class);
        Meal::observe(AgencyObserver::class);

        // Register event listeners
        Event::listen(
            UserRegistered::class,
        );

        Request::macro('agencyId', function () {
            return auth('vendor-api')->user()->agency_id ?? session('agency_id');
        });

        // Configure Apple Socialite Provider
        $this->bootAppleSocialite();
    }

    /**
     * Configure Apple Socialite Provider.
     * @throws BindingResolutionException
     */
    protected function bootAppleSocialite(): void
    {
        $socialite = $this->app->make(SocialiteFactory::class);

        $socialite->extend('apple', function ($app) use ($socialite) {
            $config = $app['config']['services.apple'];
            return $socialite->buildProvider(
                \SocialiteProviders\Apple\Provider::class,
                $config
            );
        });
    }
}
