<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OnlinePendingPaymentStatus extends Model
{
    public function onlinePendingPayment()
    {
        return $this->hasMany(OnlinePendingPayment::class);
    }
}
