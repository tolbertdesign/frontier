<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Entities\Classroom;

class Payment extends Model
{
    public $timestamps = false;

    public function pledges()
    {
        return $this->hasMany(Pledge::class);
    }

    public function onlinePayments()
    {
        return $this->hasMany(OnlinePayment::class);
    }

    public function manualPayments()
    {
        return $this->hasMany(ManualPayment::class);
    }

    public function paymentsStudents()
    {
        return $this->hasMany(PaymentsStudent::class);
    }

    public function totalFeeAmount($fees)
    {
        // must type convert because fees are strings '0.00'
        $sponsorConvenienceFee = floatval($fees['sponsor_convenience_fee']);
        $feeAmount             = 0;

        if (! empty($sponsorConvenienceFee)) {
            $feeAmount = $sponsorConvenienceFee;
        }

        return $feeAmount;
    }

    public function getFees($pledgeInfo, $program)
    {
        $fees['sponsor_convenience_fee'] = $program->sponsor_convenience_fee;
        $fees['school_processing_fee']   = empty($pledgeInfo['sponsor_paying_optional_fee']) ?
            $program->school_processing_fee : 0;
        $fees['optional_sponsor_fee']    = ! empty($pledgeInfo['sponsor_paying_optional_fee']) ?
            $program->optional_sponsor_fee : 0;
        return $fees;
    }

    public function calculateAmount($pledgeInfo, $program)
    {
        $fees      = $this->getFees($pledgeInfo, $program);
        $feeAmount = $this->totalFeeAmount($fees);
        $amount    = $pledgeInfo['amount'] * count($pledgeInfo['students']) + $feeAmount;
        return $amount;
    }

    public function populatePayment($pledgeInfo, $sponsorUser, $program)
    {
        $this->created_at = Carbon::now();
        $this->amount     = $this->calculateAmount($pledgeInfo, $program);
        $this->first_name = $sponsorUser->first_name;
        $this->last_name  = $sponsorUser->last_name;
    }
}
