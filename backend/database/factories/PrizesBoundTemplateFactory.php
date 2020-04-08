<?php

use Faker\Generator as Faker;
use App\Entities\PrizesBoundTemplate;

$factory->define(PrizesBoundTemplate::class, function (Faker $faker) {
    $amount = rand(1, 10) * 30;
    return [
        'prize_id'       => 1,
        'prize_list_id'  => 1,
        'display_name'   => $faker->words(3, true),
        'display_amount' => $amount,
        'actual_amount'  => $amount,
    ];
});
