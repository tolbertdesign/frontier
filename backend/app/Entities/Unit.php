<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function programs()
    {
        $this->hasMany(Program::class);
    }
    public function unitImage()
    {
        return $this->belongsTo(UnitImage::class);
    }
}
