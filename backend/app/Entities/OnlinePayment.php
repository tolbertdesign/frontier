<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    public $timestamps = false;

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function populateOnlinePayment($payment, $ccTransaction, $pledgeInfo, $participantUsers)
    {
        $program = $participantUsers[0]->getProgram();
        $fees    = $payment->getFees($pledgeInfo, $program);

        $this->payment_id              = $payment->id;
        $this->order_id                = $ccTransaction->order_id;
        $this->sponsor_convenience_fee = $fees['sponsor_convenience_fee'];
        $this->school_processing_fee   = $fees['school_processing_fee'];
        $this->optional_sponsor_fee    = $fees['optional_sponsor_fee'];
    }
}
