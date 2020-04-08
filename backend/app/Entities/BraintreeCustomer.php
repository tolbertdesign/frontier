<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class BraintreeCustomer extends Model
{
    public $timestamps = false;

    public function braintreeTokens()
    {
        return $this->hasMany(BraintreeToken::class, 'bt_customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
