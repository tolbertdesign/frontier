<?php

use Faker\Generator as Faker;
use App\Entities\CcTransaction;

$factory->define(CcTransaction::class, function (Faker $faker) {
    return [
        'order_id'   => 'Seeded-' . rand(100000000, 999999999),
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->safeEmail,
        'phone'      => rand(1000000000, 9999999999),
        'amount'     => rand(1, 100),
        'deleted'    => 0,
    ];
});
