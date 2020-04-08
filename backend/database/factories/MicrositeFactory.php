<?php

use Faker\Generator as Faker;
use App\Entities\Microsite;
use App\Entities\MicrositeColorTheme;
use App\Entities\Program;
use App\Entities\MicrositeVideo;
use App\Entities\MicrositePic;

$factory->define(Microsite::class, function (Faker $faker) {
    return [
        'program_id'               => Program::inRandomOrder()->first()->id,
        'intro_vid_override'       => 0,
        'video_1'                  => MicrositeVideo::inRandomOrder()->first()->id,
        'video_2'                  => MicrositeVideo::inRandomOrder()->first()->id,
        'video_3'                  => MicrositeVideo::inRandomOrder()->first()->id,
        'video_4'                  => MicrositeVideo::inRandomOrder()->first()->id,
        'video_5'                  => MicrositeVideo::inRandomOrder()->first()->id,
        'slug'                     => $faker->slug(3),
        'pic_1'                    => MicrositePic::inRandomOrder()->first()->id,
        'pic_2'                    => MicrositePic::inRandomOrder()->first()->id,
        'pic_3'                    => MicrositePic::inRandomOrder()->first()->id,
        'parents_invited'          => 0,
        'hide_character_videos'    => $faker->randomElement([null, 0, 1]),
        'overview_text_override'   => $faker->text(),
        'school_image_name'        => $faker->words(5, true),
        'color_theme_id'           => MicrositeColorTheme::inRandomOrder()->first()->id,
        'funds_raised_for'         => $faker->sentence(),
        'get_pledges_vid_override' => 0
    ];
});
