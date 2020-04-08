<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Referrer extends Model
{
    public const FACEBOOK       = 1;
    public const FACEBOOK_VIDEO = 9;
    public const LINK           = 4;
    public const LINK_VIDEO     = 11;

    public function pledges()
    {
        return $this->belongsToMany(Pledge::class, 'pledge_referrers');
    }

    public function specialUrls()
    {
        return $this->hasMany(SpecialUrl::class);
    }
}
