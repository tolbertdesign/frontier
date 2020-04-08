<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PrizesBound extends Model
{
    protected $table   = 'prizes_bound';
    public $timestamps = false;

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
