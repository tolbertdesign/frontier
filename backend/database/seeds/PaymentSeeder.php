<?php

use Illuminate\Database\Seeder;
use App\Entities\Pledge;
use App\Entities\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pledges = Pledge::all()->random(150);

        foreach ($pledges as $pledge) {
            factory(Payment::class, 1)->make()->each(function ($payment) use ($pledge) {
                $payment->amount = $pledge->amount;

                if ($pledge->pledgeType->long_name != 'Flat Donation') {
                    $payment->amount *= $pledge->pledgeType->multiplier_average;
                }

                $payment->save();
                $pledge->payment_id = $payment->id;
                $pledge->save();
            });
        };
    }
}
