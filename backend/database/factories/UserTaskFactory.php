<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\UserTask;
use App\Entities\Program;
use Faker\Generator as Faker;

$factory->define(UserTask::class, function (Faker $faker) {
    return [
        'program_id'        => Program::inRandomOrder()->first()->id,
        'title'             => $faker->asciify('*****')
    ];
});
