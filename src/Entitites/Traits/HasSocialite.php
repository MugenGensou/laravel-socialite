<?php

namespace Mugen\LaravelSocialite\Entities\Traits;

use Mugen\LaravelSocialite\Entities\SocialiteUser;

trait HasSocialite
{
    public function socialites()
    {
        return $this->hasMany(SocialiteUser::class, 'user_id');
    }

    /**
     * @param string $provider
     * @return null|string
     */
    public function getOpenId(string $provider): ? string
    {
        return $this->socialites()->where('provider', $provider)->pluck('open_id')->first();
    }
}
