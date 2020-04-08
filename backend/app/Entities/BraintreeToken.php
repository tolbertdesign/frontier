<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class BraintreeToken extends Model
{
    public $timestamps = false;

    public function onlinePendingPayments()
    {
        return $this->hasMany(OnlinePendingPayment::class, 'bt_token_id');
    }

    public function braintreeCustomer()
    {
        return $this->belongsTo(BraintreeCustomer::class, 'bt_customer_id');
    }
}
