<?php

namespace Mugen\LaravelSocialite;

use Event;
use Illuminate\Support\ServiceProvider;
use Mugen\LaravelSocialite\Events\SocialiteUserAuthorized;
use Mugen\LaravelSocialite\Listeners\AutoSaveSocialiteUser;
use Overtrue\Socialite\SocialiteManager;
use Overtrue\Socialite\User;

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
        $this->setupConfig();

        $this->app->singleton(SocialiteManager::class, function ($app) {
            return new SocialiteManager(config('socialite.providers', []), $app->make('request'));
        });
    }

    /**
     *
     */
    public function boot()
    {
        $this->setupDatabase();

        if (config('socialite.enable_mock'))
            $this->setupMockAuthUser();
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

    /**
     * Setup the config.
     */
    protected function setupConfig(): void
    {
        $source = realpath(__DIR__ . '/../config/socialite.php');

        $this->publishes([
            $source => config_path('socialite.php'),
        ]);

        $this->mergeConfigFrom($source, 'socialite');
    }

    /**
     * Setup the database.
     */
    protected function setupDatabase()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Set mock login
     */
    protected function setupMockAuthUser()
    {
        $user = config('socialite.mock_user');

        if (is_array($user) && !empty($user['open_id'])) {
            foreach (array_keys(config('socialite.providers', [])) as $provider) {
                session([
                    "socialite.{$provider}.user" => new User([
                        'id'       => array_get($user, 'open_id'),
                        'name'     => array_get($user, 'nickname'),
                        'nickname' => array_get($user, 'nickname'),
                        'avatar'   => array_get($user, 'avatar'),
                        'provider' => $provider,
                        'email'    => null,
                    ])
                ]);
            }
        }
    }
}
