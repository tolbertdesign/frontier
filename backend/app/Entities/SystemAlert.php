<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemAlert extends Model
{
    public function systemAlertLocations()
    {
        return $this->hasMany(SystemAlertLocation::class);
    }
}
