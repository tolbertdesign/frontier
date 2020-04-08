<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Pledge;
use Faker\Generator as Faker;
use App\Entities\User;
use App\Entities\Program;
use App\Entities\Group;
use App\Entities\StudentsParent;
use App\Entities\Payment;
use App\Entities\PledgeSponsor;
use App\Entities\PledgeType;
use App\Entities\PledgeStatus;
use Carbon\Carbon;

$factory->define(Pledge::class, function (Faker $faker) {
    $amount = $faker->randomFloat(2, 1, 10);
    $pledgeStatusId = PledgeStatus::inRandomOrder()->first()->id;

    return [
        'participant_user_id'       => factory(User::class)->create()->id,
        'program_id'                => factory(Program::class)->create()->id,
        'family_pledge_id'          => null,
        'group_id'                  => factory(Group::class)->create()->id,
        'user_id'                   => factory(User::class)->create()->id,
        'amount'                    => $amount,
        'ip_address'                => $faker->ipv4,
        'pledge_type_id'            => $faker->randomElement([PledgeType::FLAT, PledgeType::PPL]),
        'amount'                    => $amount,
        'ip_address'                => $faker->ipv4,
        'pledge_status_id'          => $pledgeStatusId,
        'ts_entered'                => Carbon::now()->format('Y-m-d H:i:s'),
        'deleted'                   => 0,
        'protected'                 => 0,
        'payment_id'                => factory(Payment::class)->create(['amount' => $amount])->id,
        'pledge_sponsor_id'         => PledgeSponsor::inRandomOrder()->first()->id,
        'business_name'             => null,
        'business_website'          => '',
        'sponsor_type_id'           => null,

    ];
});
