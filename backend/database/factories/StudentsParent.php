<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Entities\StudentsParent;
use Faker\Generator as Faker;
use App\Entities\User;

$factory->define(StudentsParent::class, function (Faker $faker) {
    return [
        'student_id' => function () {
            return factory(User::class)->create()->id;
        },
        'parent_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
