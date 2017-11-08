<?php

namespace Mugen\LaravelSocialite\Http\Middlewares;

use Closure;
use Log;
use Overtrue\LaravelWeChat\Events\SocialiteUserAuthorized;
use Overtrue\Socialite\SocialiteManager;

class SocialiteAuthenticate
{
    private $manager;

    public function __construct(SocialiteManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Auto start transaction and log database query.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $provider = null)
    {
        $isNewSession = false;

        $provider = strtolower($provider ?? $request->get('provider'));

        if (empty($provider) || !in_array($provider, array_keys(config("socialite.services")))) {
            config('socialite.debug') && Log::debug('Not support this provider.');

            return $next($request);
        }

        $scopes = config("socialite.services.{$provider}.scopes", []);

        if (is_string($scopes)) {
            $scopes = array_map('trim', explode(',', $scopes));
        }

        if (!session("socialite.{$provider}.user")) {
            $oauth = $this->manager->driver($provider);

            if ($request->has('code')) {
                session(["socialite.{$provider}.user" => $oauth->user()]);

                Event::fire(new SocialiteUserAuthorized(session("socialite.{$provider}.user"), $isNewSession = true));

                return redirect()->to($this->getTargetUrl($request));
            }

            session()->forget("socialite.{$provider}.user");

            return $oauth->scopes($scopes)->redirect($request->fullUrl());
        }

        Event::fire(new SocialiteUserAuthorized(session("socialite.{$provider}.user"), $isNewSession));

        return $next($request);
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getTargetUrl($request)
    {
        $queries = array_except($request->query(), ['code', 'state']);

        return $request->url() . (empty($queries) ? '' : '?' . http_build_query($queries));
    }
}
