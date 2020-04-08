<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\CustomProgramAlert;
use Carbon\Carbon;
use App\Entities\Program;
use Faker\Generator as Faker;

$factory->define(CustomProgramAlert::class, function (Faker $faker) {
    return [
        'text'       => $faker->sentence,
        'start'      => Carbon::yesterday(),
        'end'        => Carbon::now()->addDays(365),
        'program_id' => Program::inRandomOrder()->first()->id,
        'active'     => '1'
    ];
});
