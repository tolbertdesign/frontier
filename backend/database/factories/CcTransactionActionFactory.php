<?php

use Faker\Generator as Faker;
use App\Entities\CcTransactionAction;

$factory->define(CcTransactionAction::class, function (Faker $faker) {
    return [
        'status'     => 'sent',
        'order_time' => $faker->dateTime(),
        'deleted'    => 0,
    ];
});
