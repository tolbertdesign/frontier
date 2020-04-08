<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Notification;
use App\Entities\Participant;
use App\Entities\Program;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    $data  = new stdClass();
    $data->content = $faker->realText(200, 1);

    return [
        'id' => $faker->uuid,
        'type' => $faker->randomElement(Notification::TYPES),
        'notifiable_type' => 'App\Entities\User',
        'notifiable_id' => Participant::inRandomOrder()->first()->user_id,
        'program_id' => Program::inRandomOrder()->first()->id,
        'data' => json_encode($data),
        'starts_at' => Carbon::yesterday(),
        'ends_at' => Carbon::now()->addDays(365),
    ];
});
