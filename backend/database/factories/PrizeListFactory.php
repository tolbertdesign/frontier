<?php

use Faker\Generator as Faker;
use App\Entities\PrizesList;

$factory->define(PrizesList::class, function (Faker $faker) {
    return [
        'display_name'    => $faker->words(3, true),
        'deleted'         => 0
    ];
});
