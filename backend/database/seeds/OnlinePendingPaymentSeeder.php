<?php

use Illuminate\Database\Seeder;
use App\Entities\Program;
use App\Entities\Pledge;
use App\Entities\OnlinePendingPayment;
use App\Entities\BraintreeCustomer;
use App\Entities\User;
use App\Entities\BraintreeToken;

class OnlinePendingPaymentSeeder extends Seeder
{
    const PAYMENT_SCHEDULED_STATUS = 8;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numPerProgram         = 10;
        $programs              = Program::all();
        $totalToCreate         = $programs->count() * $numPerProgram;
        $onlinePendingPayments = factory(OnlinePendingPayment::class, $totalToCreate)->make();
        $users                 = User::all();

        foreach ($programs as $program) {
            for ($i = 0; $i < $numPerProgram; $i++) {
                //setup braintree customer and token for payment to be processed
                $user              = $users->random();
                $bt_customer_id    = 'Seeded-' . rand(100000000, 999999999);
                $braintreeCustomer = new BraintreeCustomer([
                    'user_id'        => $user->id,
                    'bt_customer_id' => $bt_customer_id,
                    'first_name'     => $user->first_name,
                    'last_name'      => $user->last_name,
                    'email'          => $user->email,
                    'phone'          => $user->phone,
                    'address'        => $user->address,
                    'city'           => $user->city,
                    'state'          => $user->state,
                    'zip'            => $user->zip,
                    'country'        => $user->country,
                ]);
                $braintreeCustomer->save();
                $braintreeToken = new BraintreeToken([
                    'bt_customer_id' => $braintreeCustomer->id,
                    'bt_token'       => 'this is very fake fake fake fake',
                ]);
                $braintreeToken->save();

                //get pledges to pay
                $pledges = Pledge::whereNotIn('pledge_status_id', [3, 6, 7, 8])
                    ->where('program_id', '=', $program->id)
                    ->orderByRaw('RAND()')
                    ->limit(rand(1, 3))
                    ->get();

                //pay for pledges
                $onlinePendingPayment                 = $onlinePendingPayments->pop();
                $onlinePendingPayment->bt_customer_id = $braintreeCustomer->id; //fix me
                $onlinePendingPayment->bt_token_id    = $braintreeToken->id; //fix me
                $onlinePendingPayment->save();
                $onlinePendingPayment->pledges()->attach($pledges);

                //set pledges to payment scheduled;
                $pledges->each(function ($pledge) {
                    $pledge->pledge_status_id = self::PAYMENT_SCHEDULED_STATUS;
                    $pledge->save();
                });
            }
        }
    }
}
