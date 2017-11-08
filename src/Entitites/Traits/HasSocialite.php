<?php

namespace Mugen\LaravelSocialite\Entities\Traits;

use Mugen\LaravelSocialite\Entities\SocialiteUser;

trait HasSocialite
{
    public function socialites()
    {
        return $this->hasMany(SocialiteUser::class, 'user_id');
    }
}
