<?php

use Faker\Generator as Faker;
use App\Entities\School;

$factory->define(School::class, function (Faker $faker) {
    return [
        'name'    => $faker->company,
        'type'    => 'Client',
        'address' => $faker->streetAddress,
        'city'    => $faker->city,
        'state'   => $faker->stateAbbr,
        'zip'     => $faker->postcode
    ];
});
