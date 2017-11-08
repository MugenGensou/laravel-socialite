<?php

namespace Overtrue\LaravelWeChat\Events;

use Illuminate\Queue\SerializesModels;
use Mugen\LaravelSocialite\Entities\SocialiteUser;
use Overtrue\Socialite\User;

class SocialiteUserAuthorized
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var bool
     */
    public $isNewSession;

    /**
     * @var SocialiteUser
     */
    public $socialiteUser;

    /**
     * Create a new event instance.
     *
     * @param \Overtrue\Socialite\User $user
     * @param bool $isNewSession
     */
    public function __construct(User $user, bool $isNewSession = false)
    {
        $this->user = $user;

        $this->isNewSession = $isNewSession;

        if (config('socialite.auto_save'))
            $this->socialiteUser = SocialiteUser::create([
                'paltform' => 'web',
                'provider' => $user->getProviderName(),
                'open_id'  => $user->getId(),
                'nickname' => $user->getNickname(),
                'name'     => $user->getName(),
                'email'    => $user->getEmail(),
                'avatar'   => $user->getAvatar(),
                'token'    => $user->getToken()->toArray(),
            ]);

    }

    /**
     * Retrieve the authorized user.
     *
     * @return \Overtrue\Socialite\User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Check the user session is first created.
     *
     * @return bool
     */
    public function isNewSession(): bool
    {
        return $this->isNewSession;
    }

    /**
     * @return SocialiteUser
     */
    public function getSocialiteUser():?SocialiteUser
    {
        return $this->socialiteUser;
    }
}
