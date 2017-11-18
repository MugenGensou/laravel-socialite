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
            return new SocialiteManager(config('socialite.services', []), $app->make('request'));
        });
    }

    /**
     *
     */
    public function boot()
    {
        if (config('socialite.auto_save')) {
            $this->setupDatabase();
            $this->setupEvents();
        }

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
     * Setup the events & listeners.
     */
    protected function setupEvents()
    {
        Event::listen(SocialiteUserAuthorized::class, AutoSaveSocialiteUser::class);
    }

    /**
     * Set mock login
     */
    protected function setupMockAuthUser()
    {
        $request  = $this->app->make('request');
        $provider = $request->get('provider') ?? $request->route('provider');
        $user     = config('socialite.mock_user');

        if (is_array($user) && !empty($user['open_id'])) {
            $user = (new User([
                'id'       => array_get($user, 'open_id'),
                'name'     => array_get($user, 'name'),
                'nickname' => array_get($user, 'nickname'),
                'avatar'   => array_get($user, 'avatar'),
                'email'    => null,
            ]))
                ->merge(['original' => $user])
                ->setProviderName($provider);

            session(["socialite.{$provider}.user" => $user]);
        }
    }
}
