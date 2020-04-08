<?php

use Faker\Generator as Faker;
use App\Entities\UserTaskTemplate;

$factory->define(UserTaskTemplate::class, function (Faker $faker) {

    $labels = [
        'Parent Communication', 'More Fun!',
        '$ Increase', '$$ Increase', '$$$ Increase'
    ];

    return [
        'title' => $faker->sentence(rand(2, 4)),
        'label' => $labels[rand(0, 4)]
    ];
});
