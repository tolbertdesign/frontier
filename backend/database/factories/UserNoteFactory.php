<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Entities\UserNote;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

//Carbon::now()->format('Y-m-d H:i:s')
$factory->define(UserNote::class, function (Faker $faker) {
    return [
        'note'         => $faker->sentence,
        'created'      => Carbon::now()->format('Y-m-d H:i:s'),
        'last_updated' => Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
