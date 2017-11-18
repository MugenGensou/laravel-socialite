<?php

namespace Mugen\LaravelSocialite\Events;

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

    /**
     * @param SocialiteUser $socialiteUser
     */
    public function setSocialiteUser(SocialiteUser $socialiteUser): void
    {
        $this->socialiteUser = $socialiteUser;
    }
}
