<?php

use Faker\Generator as Faker;
use App\Entities\OnlinePendingPayment;
use App\Entities\OnlinePendingPaymentPledge;
use App\Entities\Pledge;

$factory->define(OnlinePendingPaymentPledge::class, function (Faker $faker) {
    return [
        'pledge_id'                     => factory(Pledge::class)->create()->id,
        'deleted'                       => 0,
    ];
});
