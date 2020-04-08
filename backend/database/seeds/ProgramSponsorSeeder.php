<?php

use Illuminate\Database\Seeder;
use App\Entities\Program;
use App\Entities\ProgramSponsor;

class ProgramSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programSponsor = new ProgramSponsor([
            'id'   => 1,
            'name' => 'Florida Prepaid',
        ]);
        $programSponsor->save();
        $programs = Program::all();
        $programs->each(function ($program) use ($programSponsor) {
            $program->programSponsors()->save($programSponsor);
        });
    }
}
