<?php

use Faker\Generator as Faker;
use App\Entities\Program;
use App\Entities\Group;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'salesforce_id'            => $faker->regexify('[a-zA-Z0-9]{18}'),
        'name'                     => 'Primary',
        'program_id'               => 1,
        'actual_students_override' => 0,
        'level'                    => 'Primary',
        'sf_program_id'            => $faker->regexify('[a-zA-Z0-0]{18}'),
        'sf_opportunity_id'        => '',
        'deleted'                  => 0
    ];
});
