<?php

use Faker\Generator as Faker;
use App\Entities\PotentialSponsor;

$factory->define(PotentialSponsor::class, function (Faker $faker) {
    return [
        'email'               => $faker->unique()->safeEmail,
        'first_name'          => $faker->firstName,
        'last_name'           => $faker->lastName,
        'sponsor_user_id'     => 0,
        'deleted'             => rand(0, 1),
        'enrollment'          => 1,
        'day_before_run'      => 0,
        'day_after_run'       => 0,
        'opt_out'             => 0,
        'participant_user_id' => 0
    ];
});
