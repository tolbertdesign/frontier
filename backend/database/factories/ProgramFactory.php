<?php

use Faker\Generator as Faker;
use App\Entities\Program;
use App\Entities\School;
use App\Entities\Prize;
use App\Entities\Role;
use App\Entities\Microsite;
use \Carbon\Carbon;
use App\Entities\MicrositeColorTheme;

$factory->define(Program::class, function (Faker $faker) {
    return [
        'name'                          => $faker->company,
        'school_id'                     => factory(School::class)->create()->id,
        'projected_raised'              => $faker->randomNumber,
        'pep_rally'                     => Carbon::now()->subDays($faker->numberBetween(0, 10)),
        'fun_run'                       => Carbon::now()->addDays($faker->numberBetween(0, 10)),
        'due_date'                      => Carbon::now()->addDays($faker->numberBetween(10, 12)),
        'deleted'                       => 0,
        'team_id'                       => Role::where('type', 'team')->inRandomOrder()->first()->id,
        'owner_id'                      => $faker->randomNumber,
        'sf_opportunity_id'             => $faker->regexify('[a-zA-Z0-9]{0,18}'),
        'salesforce_id'                 => $faker->unique()->asciify('******************'),
        'salesforce_team_id'            => $faker->name,
        'sf_school_id'                  => $faker->unique()->asciify('******************'),
        'sf_owner_id'                   => $faker->unique()->asciify('******************'),
        'collection_type'               => $faker->boolean(98) ? 'basic' : 'donor_base',
        'pledging_start'                => $faker->date,
        'collection_refer_key'          => $faker->unique()->asciify('********'),
        'sponsor_convenience_fee'       => $faker->randomFloat(2, 0, 5),
        'optional_sponsor_fee'          => $faker->randomFloat(2, 0, 5),
        'school_processing_fee'         => $faker->randomFloat(2, 0, 5),
        'online_payment_enabled'        => 1,
        'total_raised_goal'             => $faker->randomFloat(2, 0, 5),
        'archived'                      => 0,
        'open_help'                     => 0,
        'registration_code'             => $faker->unique()->asciify('3*****'),
        'event_name'                    => $faker->company . ' Fund Raiser',
        'parent_email_prompts'          => 1,
        'facebook_share_prize'          => 0,
        'has_delivered_top_prizes'      => $faker->boolean,
        'online_payment_required'       => $faker->boolean(80),
        'unit_id'                       => $faker->numberBetween(1, 6),
        'has_delivered_teacher_prizes'  => $faker->boolean,
        'promote_pay_online'            => $faker->boolean(80),
        'semester'                      => date('Y') . (date('m') < 7 ? '-1-Spring' : '-2-Fall')
    ];
});
$logos = collect([
    ['filename' => '2000px-Georgia_Athletics_logo.svg.png'],
    ['filename' => 'logo2.png'],
    ['filename' => 'logo3.png'],
    ['filename' => 'logo4.png'],
    ['filename' => 'school logo.jpg'],
    ['filename' => 'School logo2.jpg']
]);

$factory->afterCreating(Program::class, function ($program, $faker) use ($logos) {
    $microsite = new Microsite();
    $microsite->program_id = $program->id;
    $microsite->intro_vid_override       = '0';
    $microsite->video_1                  = 1;
    $microsite->video_2                  = 2;
    $microsite->video_3                  = 3;
    $microsite->video_4                  = 4;
    $microsite->video_5                  = 5;
    $microsite->slug                     = $faker->slug;
    $microsite->pic_1                    = 1;
    $microsite->pic_2                    = 2;
    $microsite->pic_3                    = null;
    $microsite->parents_invited          = 0;
    $microsite->last_updated             = '2016-09-27 13:01:12';
    $microsite->hide_character_videos    = null;
    $microsite->overview_text_override   = $faker->boolean(5) ? $faker->text(300) : '';
    $microsite->school_image_name        = $logos->random()['filename'];
    $microsite->color_theme_id           = MicrositeColorTheme::inRandomOrder()->first()->id;
    $microsite->funds_raised_for         = $faker->sentence(4, true);
    $microsite->get_pledges_vid_override = 0;
    $microsite->save();
});
