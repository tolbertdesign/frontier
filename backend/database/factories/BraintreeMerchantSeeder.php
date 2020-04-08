<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\BraintreeMerchant;
use Faker\Generator as Faker;

$factory->define(BraintreeMerchant::class, function (Faker $faker) {
    return [
        'first_name'            => $faker->firstName(),
        'last_name'             => $faker->lastName(),
        'email'                 => $faker->email(),
        'point_person_phone'    => $faker->asciify('##########'),
        'dob'                   => '1986-08-27',
        'point_person_address'  => $faker->streetAddress(),
        'point_person_city'     => $faker->city,
        'point_person_state'    => $faker->stateAbbr,
        'point_person_zip'      => $faker->postcode,
        'legal_name'            => $faker->company(),
        'dba'                   => $faker->company(),
        'tax_id'                => $faker->asciify('#########'),
        'organization_address'  => $faker->streetAddress(),
        'organization_city'     => $faker->city,
        'organization_state'    => $faker->stateAbbr,
        'organization_zip'      => $faker->postcode,
        'account_number'        => $faker->asciify('\*\*\*\*####'),
        'routing_number'        => $faker->asciify('\*\*\*\*\*\*\*#'),
        'school_id'             => 1,
        'status'                => 'active',
        'tos'                   => 1,
        'approval_status'       => 'approved',
        'error_message'         => null,
        'errors'                => null,
        'braintree_merchant_id' => $faker->company(),
        'escrow_funds'          => $faker->boolean(),
        'account_type'          => '',
    ];
});
