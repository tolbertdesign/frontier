<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Episode;
use App\Entities\Podcast;
use Faker\Generator as Faker;

$factory->define(Episode::class, function (Faker $faker) {
    return [
        'podcast_id' => factory(Podcast::class),
        'number' => $faker->word,
        'title' => $faker->word,
        'url' => $faker->url,
        'content_text' => $faker->text,
        'content_html' => $faker->text,
        'published_at' => $faker->dateTime(),
        'download_url' => $faker->word,
        'duration' => $faker->word,
        'price' => $faker->randomNumber(),
    ];
});
