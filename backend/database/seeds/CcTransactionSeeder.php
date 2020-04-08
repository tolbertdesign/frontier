<?php

use Illuminate\Database\Seeder;
use App\Entities\OnlinePayment;
use App\Entities\CcTransaction;
use App\Entities\CcTransactionAction;

class CcTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $onlinePayments = OnlinePayment::all();
        $onlinePayments->each(function ($onlinePayment) {
            //make transaction
            $ccTransaction = factory(CcTransaction::class)->make();
            $ccTransaction->order_id = $onlinePayment->order_id;
            $ccTransaction->amount = $onlinePayment->payment->amount;
            $ccTransaction->merchant_id = $onlinePayment
                ->payment
                ->pledges()->first()
                ->program
                ->school
                ->braintreeMerchant
                ->id;
            $ccTransaction->save();

            //make transaction pledges
            $ccTransaction->pledges()->attach($onlinePayment->payment->pledges);

            //make transaction actions
            $ccTransactionActions = factory(CcTransactionAction::class, 2)->make()->sortBy('order_time');
            $ccTransactionActions[0]->status = 'sent';
            $ccTransactionActions[1]->status = 'paid';
            $ccTransactionActions->each(function ($ccTransactionAction) use ($ccTransaction) {
                $ccTransaction->ccTransactionActions()->save($ccTransactionAction);
            });
        });
    }
}
