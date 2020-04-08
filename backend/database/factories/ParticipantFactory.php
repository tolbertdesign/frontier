<?php

use Faker\Generator as Faker;
use App\Entities\Participant;
use App\Entities\User;
use App\Entities\Classroom;

$factory->define(Participant::class, function (Faker $faker) {
    return [
        'classroom_id'             => Classroom::inRandomOrder()->first()->id,
        'user_id'                  => factory(User::class)->create()->id,
        'family_pledging_enabled'  => $faker->boolean,
        'allow_pay_later_override' => $faker->boolean
    ];
});
