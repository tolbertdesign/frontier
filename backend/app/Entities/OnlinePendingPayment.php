<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OnlinePendingPayment extends Model
{
    const STATUS_PENDING = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_PAID = 3;

    public $timestamps = false;

    public static $statusPaymentScheduled = [self::STATUS_PENDING, self::STATUS_PROCESSING, self::STATUS_PAID];

    public function pledges()
    {
        return $this->belongsToMany(
            Pledge::class,
            'online_pending_payment_pledges',
            'online_pending_payments_id',
            'pledge_id'
        );
    }

    public function onlinePendingPaymentStatus()
    {
        return $this->belongsTo(OnlinePendingPaymentStatus::class);
    }

    public function braintreeToken()
    {
        return $this->belongsTo(BraintreeToken::class, 'bt_token_id');
    }
}
