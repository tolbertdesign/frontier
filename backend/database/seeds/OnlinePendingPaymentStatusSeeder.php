<?php

use Illuminate\Database\Seeder;
use App\Entities\OnlinePendingPaymentStatus;

class OnlinePendingPaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OnlinePendingPaymentStatus::insert([
            [
                'name' => 'Pending',
            ], [
                'name' => 'Processing',
            ], [
                'name' => 'Paid',
            ], [
                'name' => 'Denied',
            ]
        ]);
    }
}
