<?php

use App\Entities\Crud;
use Faker\Generator as Faker;

$factory->define(Crud::class, function (Faker $faker) {
    return [
        'name' => $faker->lexify('????????'),
        'color' => $faker->boolean ? 'red' : 'green'
    ];
});
