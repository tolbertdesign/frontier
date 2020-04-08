<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PledgePeriod extends Model
{
    public $timestamps = false;

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
