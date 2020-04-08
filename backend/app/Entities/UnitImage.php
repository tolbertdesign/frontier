<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UnitImage extends Model
{
    public function units()
    {
        $this->hasMany(Unit::class);
    }
}
