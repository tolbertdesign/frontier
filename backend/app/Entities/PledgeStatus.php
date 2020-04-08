<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PledgeStatus extends Model
{
    public function pledges()
    {
        return $this->hasMany(Pledge::class);
    }
}
