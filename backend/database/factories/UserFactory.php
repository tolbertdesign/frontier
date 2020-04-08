<?php

use App\Entities\Classroom;
use App\Entities\Group;
use App\Entities\Participant;
use App\Entities\Program;
use Faker\Generator as Faker;
use App\Entities\User;
use Carbon\Carbon;
use App\Libraries\FrCodeGenerator;
use Illuminate\Support\Facades\DB;

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

$factory->define(User::class, function (Faker $faker) {
    $email = rand(0, 9999999) . $faker->unique()->safeEmail;
    return [
        'ip_address'                => $faker->ipv4,
        'username'                  => $email,
        'password'                  => bcrypt('secret'),
        'email'                     => $email,
        'active'                    => 1,
        'first_name'                => $faker->firstName,
        'last_name'                 => $faker->lastName,
        'phone'                     => rand(1000000000, 10000000000),
        'fr_code'                   => FrCodeGenerator::generate(),
        'address'                   => $faker->address,
        'city'                      => $faker->city,
        'state'                     => $faker->stateAbbr,
        'zip'                       => $faker->postcode,
        'country'                   => $faker->countryCode,
        'company'                   => $faker->company,
        'dob'                       => $faker->date('Y-m-d', '2001-01-01'),
        'registered'                => 1,
        'deleted'                   => 0,
        'flagging_mode_id'          => 1,
        'block_collection_reminder' => 0,
        'reg_code_temp_user'        => 0,
        'email_opt_out'             => 0,
        'public_pledger'            => 0,
        'created_on'                => Carbon::now()->timestamp,
        'laps'                      => $faker->randomElement(range(0, 10))
    ];
    // 'last_login'                => Carbon::now()->format('Y-m-d H:i:s'),
        // 'salt' => ,
        // 'activation_code' => ,
        // 'forgotten_password_code' => ,
        // 'forgotten_password_time' => ,
        // 'remember_code' => ,
        // 'created_on' => ,
        // 'gender' => ,
        // 'in_service' => , //dead field?
        // 'origin' => ,
        // 'salesforce_worker_id' => ,
        // 'salesforce_user_id' => ,
        // 'salesforce_team_id' => ,
        // 'salesforce_profile_id' => ,
        // 'salesforce_contact_id' => ,
        // 'laps' => ,
        // 'original_laps_count' => ,
        // 'laps_modified_by_user_id' => ,
        // 'laps_modified_ts' => ,
        // 'api_token' => ,
        // 'waiver_signed' => ,
        // 'waiver_dob' => ,
        // 'waiver_ts' => ,
        // 'ts_laps_entered' => ,
        // 'requested_pay_later_override' => ,
        // 'remember_token' => ,
        // 'created_at' =>
        // 'updated_at' =>
        // 'deleted_at' =>
});

$factory->state(User::class, 'parent', function ($faker) {
    return [

    ];
});

// Turn User into a parent with 1 participant
$factory->afterCreatingState(User::class, 'parent', function ($user, $faker) {
    $program = factory(Program::class)->create([
        'fun_run'  => Carbon::tomorrow(),
        'archived' => 0
    ]);

    $group = factory(Group::class)->create([
        'program_id' => $program->id
    ]);

    $classroom = factory(Classroom::class)->create([
        'group_id' => $group->id
    ]);

    $participantUser = factory(User::class)->create();

    factory(Participant::class)->create([
        'user_id'      => $participantUser->id,
        'classroom_id' => $classroom->id
    ]);

    DB::table('students_parents')->insert([
        'student_id' => $participantUser->id,
        'parent_id'  => $user->id
    ]);
});
