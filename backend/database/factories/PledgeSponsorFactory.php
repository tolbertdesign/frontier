<?php

use Faker\Generator as Faker;
use App\Entities\PledgeSponsor;

$factory->define(PledgeSponsor::class, function (Faker $faker) {
    return [
        'email'           => $faker->unique()->safeEmail,
        'first_name'      => $faker->firstName,
        'last_name'       => $faker->lastName
    ];
});
