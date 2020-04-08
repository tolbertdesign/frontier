<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Subscription::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'podcast_id' => factory(App\Podcast::class),
    ];
});
