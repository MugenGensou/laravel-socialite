<?php

namespace Mugen\LaravelSocialite\Listeners;

use Mugen\LaravelSocialite\Entities\SocialiteUser;
use Mugen\LaravelSocialite\Events\SocialiteUserAuthorized;

class AutoSaveSocialiteUser
{
    /**
     * @param SocialiteUserAuthorized $event
     */
    public function handle(SocialiteUserAuthorized $event): void
    {
        if ($event->isNewSession()) {
            $user = $event->getUser();

            $socialiteUser = SocialiteUser::firstOrCreate([
                'platform' => 'web',
                'provider' => $user->getProviderName(),
                'open_id'  => $user->getId(),
            ]);

            $socialiteUser->update([
                'nickname' => $user->getNickname() ?? '',
                'name'     => $user->getName() ?? '',
                'email'    => $user->getEmail() ?? '',
                'avatar'   => $user->getAvatar() ?? '',
                'token'    => $user->getToken()->toJSON(),
            ]);

            $event->setSocialiteUser($socialiteUser);
        }
    }
}
