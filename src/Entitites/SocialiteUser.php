<?php

namespace Mugen\LaravelSocialite\Entities;

use Illuminate\Database\Eloquent\Model;

class SocialiteUser extends Model
{
    protected $casts = [
        'user_id'  => 'integer',
        'platform' => 'string',
        'provider' => 'string',
        'open_id'  => 'string',
        'nickname' => 'string',
        'name'     => 'string',
        'email'    => 'string',
        'avatar'   => 'string',
        'token'    => 'string',
    ];
    protected $fillable = [
        'user_id',
        'platform',
        'provider',
        'open_id',
        'nickname',
        'name',
        'email',
        'avatar',
        'token',
        'expires_at',
    ];

    protected $dates = [
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(config('socialite.auth.model'), 'user_id');
    }
}
