<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PrizesBoundTemplate extends Model
{
    protected $table   = 'prizes_bound_template';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prizeList()
    {
        return $this->belongsTo(PrizeList::class);
    }

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
