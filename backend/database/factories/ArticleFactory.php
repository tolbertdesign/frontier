<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'excerpt' => $faker->text,
        'body' => $faker->text,
    ];
});
