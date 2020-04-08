<?php

use Faker\Generator as Faker;

$videos = [
    [
        'hash'         => 'Uv-IZDxdZbM',
        'original_url' => 'https://www.youtube.com/watch?v=Uv-IZDxdZbM',
    ], [
        'hash'         => '9yzeWoelJ3M',
        'original_url' => 'http://www.youtube.com/watch?v=9yzeWoelJ3M',
    ]
];

$factory->define(App\Entities\MicrositeVideo::class, function (Faker $faker) use ($videos) {
    $rand_key = array_rand($videos, 1);
    return [
        'description'  => $faker->sentence,
        'hash'         => $videos[$rand_key]['hash'],
        'url'          => null,
        'original_url' => $videos[$rand_key]['original_url'],
        'source'       => 'youtube',
        'timestamp'    => '2015-12-30 14:30:08',
    ];
});
