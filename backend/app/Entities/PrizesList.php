<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PrizesList extends Model
{
    protected $table   = 'prizes_list';
    public $timestamps = false;

    public function prizesBoundTemplates()
    {
        return $this->hasMany(PrizesBoundTemplate::class, 'prize_list_id');
    }
}
