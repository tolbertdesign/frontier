<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CcTransaction extends Model
{
    public $timestamps = false;

    public function ccTransactionActions()
    {
        return $this->hasMany(CcTransactionAction::class);
    }

    public function pledges()
    {
        return $this->belongsToMany(Pledge::class, 'cc_transaction_pledges');
    }

    public static function generateOrderId()
    {
        return substr(sha1(microtime(true) . mt_rand(10000, 90000)), 0, 12);
    }

    public function populateCcTransaction($payment, $pledgeSponsor, $program, $orderId)
    {
        $this->order_id    = $orderId;
        $this->first_name  = $pledgeSponsor->first_name;
        $this->last_name   = $pledgeSponsor->last_name;
        $this->email       = $pledgeSponsor->email;
        $this->phone       = $pledgeSponsor->phone;
        $this->amount      = $payment->amount;
        $this->merchant_id = $program->school->braintreeMerchant->braintree_merchant_id;
    }
}
