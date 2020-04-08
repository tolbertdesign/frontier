<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OnlinePendingPaymentPledge extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'online_pending_payments_id'
    ];
}
