<?php

use Faker\Generator as Faker;
use App\Entities\Group;
use App\Entities\Classroom;

$factory->define(Classroom::class, function (Faker $faker) {
    return [
        'grade_id'               => $faker->numberBetween(-2, 12),
        'name'                   => $faker->name,
        'group_id'               => Group::inRandomOrder()->first()->id,
        'last_updated'           => $faker->date('Y-m-d h:i:s'),
        'number_of_participants' => $faker->randomDigit,
        'team_member_code'       => $faker->randomNumber(8),
        'team_leader_code'       => $faker->randomNumber(8),
        'pledge_meter'           => $faker->randomFloat(2, 0, 100),
        'deleted'                => $faker->boolean(10)
    ];
});
