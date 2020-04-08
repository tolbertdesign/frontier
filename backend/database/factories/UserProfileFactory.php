<?php

use Faker\Generator as Faker;
use App\Entities\UserProfile;
use Carbon\Carbon;

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

$factory->define(UserProfile::class, function (Faker $faker) {
    $profileImages = collect([
        [ 'filename' => '789116191536074.2C1gfo3bVk5wSWdLRg2s_height6402.png'],
        [ 'filename' => 'a1667e901fdc63e8013a06d583fa1076.jpeg'],
        [ 'filename' => 'girl photo.jpg'],
        [ 'filename' => 'little boy.png'],
        [ 'filename' => 'little boy2.jpg'],
        [ 'filename' => 'little girl 2.jpg'],
        [ 'filename' => 'little girl.jpg'],
        [ 'filename' => 'test.jpeg']
    ]);


    return [
        'pledge_page_text' => $faker->paragraph,
        'video_url'        => null,
        'image_name'       => $faker->boolean(23) ? $profileImages->random()['filename'] : null,
        'pledge_goal'      => 10,
        'video_url_orig'   => null,
        'created'          => '2014-01-05 20:50:51',
    ];
});
