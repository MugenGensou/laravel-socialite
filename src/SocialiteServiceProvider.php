<?php

namespace Mugen\LaravelSocialite;

use Illuminate\Support\ServiceProvider;
use Overtrue\Socialite\SocialiteManager;

class SocialiteServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../condig/socialite.php', 'socialite');

        $this->app->singleton(SocialiteManager::class, function ($app) {
            $config = array_merge(config('socialite.services', []), config('services', []));
            return new SocialiteManager($config, $app->make('request'));
        });
    }

    /**
     *
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../condig/socialite.php' => config_path('socialite.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            SocialiteManager::class
        ];
    }
}
