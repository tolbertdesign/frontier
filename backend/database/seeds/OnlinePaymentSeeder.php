<?php

use Illuminate\Database\Seeder;
use App\Entities\Program;
use App\Entities\OnlinePayment;
use App\Entities\Pledge;
use App\Entities\Payment;

class OnlinePaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberToCreate = 50;
        $pledges        = Pledge::whereNotIn('pledge_status_id', [3, 8])
            ->orderByRaw('RAND()')
            ->limit($numberToCreate)
            ->get();
        $onlinePayments =factory(OnlinePayment::class, $numberToCreate)->make();

        factory(Payment::class, $numberToCreate)->make()->each(
            function ($payment) use ($pledges, $onlinePayments) {
                //grab online payment and pledge for this payment
                $onlinePayment = $onlinePayments->pop();
                $pledge        = $pledges->pop();

                //set values on payment
                $pledgeValue     = $pledge->amount * ($pledge->type == 1 ? 30 : 1);
                $feeSum          = $onlinePayment->sponsor_convenience_fee
                    + $onlinePayment->school_processing_fee
                    + $onlinePayment->optional_sponsor_fee;
                $payment->amount = $pledgeValue + $feeSum;
                $payment->save();

                //set values on online payment
                $onlinePayment->payment_id = $payment->id;
                $onlinePayment->save();

                //set values on pledge for paid
                $pledge->pledge_status_id = 3;
                $pledge->payment_id = $payment->id;
                $pledge->save();
            }
        );
    }
}
