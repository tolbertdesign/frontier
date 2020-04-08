<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class EnteredLocation extends Model
{
    public const GIVING_MARKET_DASHBOARD = 4;

    public function pledges()
    {
        return $this->belongsToMany(Pledge::class, 'pledge_entered_location');
    }
}
