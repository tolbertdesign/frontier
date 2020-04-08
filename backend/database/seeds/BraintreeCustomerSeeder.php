<?php

use Illuminate\Database\Seeder;
use App\Entities\BraintreeCustomer;
use App\Entities\User;

class BraintreeCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->make()->each(function ($user) {
            $user->save();

            BraintreeCustomer::insert([
                'user_id'        => $user->id,
                'bt_customer_id' => 'Seeded-' . rand(100000000, 999999999),
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
        });
    }
}
