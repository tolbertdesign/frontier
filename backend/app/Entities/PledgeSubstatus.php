<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PledgeSubstatus extends Model
{
    public function pledges()
    {
        return $this->hasMany(Pledge::class);
    }
}
