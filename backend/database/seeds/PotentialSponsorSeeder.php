<?php

use Illuminate\Database\Seeder;
use App\Entities\Participant;
use App\Entities\PotentialSponsor;

class PotentialSponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $participants = Participant::all();
        $participants->each(function ($participant) {
            $rand = rand(2, 5);
            for ($i = 0; $i < $rand; $i++) {
                $potentialSponsor = factory(PotentialSponsor::class)->make();
                $potentialSponsor->participant_user_id = $participant->id;
                $potentialSponsor->sender_user_id = $participant->user->parents[0]->id;
                $potentialSponsor->opt_out = $i % 2;
                $potentialSponsor->save();
            }
        });
    }
}
