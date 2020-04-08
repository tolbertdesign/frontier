<?php

use Faker\Generator as Faker;
use App\Entities\Payment;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'created_at'      => $faker->dateTimeBetween('2017-08-01 00:00:00', '2017-08-31 00:00:00'),
        'amount'          => null,
        'note'            => null,
        'first_name'      => $faker->firstName,
        'last_name'       => $faker->lastName,
        'address'         => $faker->address,
        'phone'           => rand(1000000000, 10000000000),
        'city'            => $faker->city,
        'state'           => $faker->stateAbbr,
        'zip'             => $faker->postcode,
        'receipt'         => null,
        'entered_by_name' => null,
        'deleted'         => 0,
    ];
});
