<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Entities\Podcast::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'title' => $faker->word,
        'description' => $faker->text,
        'website' => $faker->word,
        'cover_path' => $faker->word,
        'published_at' => $faker->dateTime(),
    ];
});
