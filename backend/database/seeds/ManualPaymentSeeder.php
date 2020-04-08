<?php

use Illuminate\Database\Seeder;
use App\Entities\Pledge;
use App\Entities\Payment;
use App\Entities\Classroom;
use App\Entities\ManualPayment;

class ManualPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classrooms = Classroom::all();

        factory(Payment::class, 50)->make()->each(
            function ($payment) use ($classrooms) {
                $payment->amount = rand(10, 100);
                $payment->save();

                $paymentTypes = ['cash', 'check'];
                $paymentTypeKey = array_rand($paymentTypes);
                $checkNumber = ($paymentTypes[$paymentTypeKey] == 'check') ? rand(1000, 9999) : null;

                $manualPayment = new ManualPayment([
                    'payment_id'      => $payment->id,
                    'entered_by'      => rand(1, 3),
                    'type'            => $paymentTypes[$paymentTypeKey],
                    'check_number'    => $checkNumber,
                    'classroom_id'    => $classrooms->random()->id,
                ]);
                $manualPayment->save();
            }
        );
    }
}
