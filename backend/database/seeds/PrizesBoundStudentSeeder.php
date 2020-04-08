<?php

use Illuminate\Database\Seeder;
use App\Entities\Group;
use App\Entities\PrizesBoundStudent;
use App\Entities\Participant;

class PrizesBoundStudentSeeder extends Seeder
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
            $prizesBound = $participant->classroom->group->prizesBound;
            $prizesBound->each(function ($prizeBound) use ($participant) {
                $prizeStatuses = collect(['unassigned', 'delivered', 'pending', 'giveaway']);
                PrizesBoundStudent::insert([
                    'student_id' => $participant->user_id,
                    'prize_id'   => $prizeBound->prize_id,
                    'status'     => $prizeStatuses->random(),
                ]);
            });
        });
    }
}
