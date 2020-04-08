<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class BraintreeMerchant extends Model
{
    public $timestamps = false;

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
