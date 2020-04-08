<?php

use Illuminate\Database\Seeder;
use App\Entities\Program;
use App\Entities\ProgramPledgeSetting;

class ProgramPledgeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = Program::where('id', '!=', 7)->get();
        $programs->each(function ($program) {
            $programPledgeSetting = factory(ProgramPledgeSetting::class)->make();
            $program->programPledgeSetting()->save($programPledgeSetting);
        });

        $programPledgeSetting = new ProgramPledgeSetting([
            'program_id'                        => 7,
            'flag_high_donation'                => 90,
            'flag_high_cumulative_per_period'   => 150,
            'weekend_challenge_amount'          => 2,
            'flag_high_quantity_per_period'     => 5,
            'flat_donate_only'                  => 1,
            'ppu_donations_only'                => null,
            'flag_payment_scheduled_high_value' => 150,
            'recommended_pledge_amounts'        => 'a:4:{s:8:"perlap_a";a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;' .
                's:1:"3";i:3;s:1:"5";i:4;s:2:"10";}s:8:"perlap_b";a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3' .
                '";i:3;s:1:"5";i:4;s:2:"10";}s:6:"flat_a";a:5:{i:0;s:2:"30";i:1;s:2:"60";i:2;s:2:"90";i:3' .
                ';s:3:"150";i:4;s:3:"300";}s:6:"flat_b";a:5:{i:0;s:2:"30";i:1;s:2:"60";i:2;s:2:"90";i:3;s' .
                ':3:"150";i:4;s:3:"300";}}',
            'family_pledging_enabled'           => 1,
            'minimize_flat_donation'            => 0,
        ]);
        $programPledgeSetting->save();
    }
}
