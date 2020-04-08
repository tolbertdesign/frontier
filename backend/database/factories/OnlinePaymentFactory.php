<?php

use Faker\Generator as Faker;
use App\Entities\OnlinePayment;

$factory->define(OnlinePayment::class, function (Faker $faker) {
    $feeChoices = collect([
        [
            'sponsor_convenience_fee' => '2.00',
            'school_processing_fee'   => '0.00',
            'optional_sponsor_fee'    => '0.00',
        ], [
            'sponsor_convenience_fee' => '0.00',
            'school_processing_fee'   => '2.00',
            'optional_sponsor_fee'    => '0.00',
        ], [
            'sponsor_convenience_fee' => '0.00',
            'school_processing_fee'   => '0.00',
            'optional_sponsor_fee'    => '2.00',
        ],
    ]);
    $fee = $feeChoices->random();
    return [
        'order_id'                => 'Seeded-' . rand(100000000, 999999999),
        'sponsor_convenience_fee' => $fee['sponsor_convenience_fee'],
        'school_processing_fee'   => $fee['school_processing_fee'],
        'optional_sponsor_fee'    => $fee['optional_sponsor_fee'],
        'deleted'                 => rand(0, 1),
    ];
});
