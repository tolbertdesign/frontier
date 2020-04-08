<?php

use Faker\Generator as Faker;

$images = [
    'prod_c59ffab6_playgrounds.jpg',
    'prod_34b1a7c9_science_lab.jpg',
    'prod_bc3cb0ad_books.jpg',
    'prod_1e05f617_technology.jpg',
    'ipad.png',
];

$factory->define(App\Entities\MicrositePic::class, function (Faker $faker) use ($images) {
    return [
        'image'      => $faker->randomElement($images),
        'description'=> $faker->words(3, true),
    ];
});
