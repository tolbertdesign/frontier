<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\Group;
use App\Entities\Classroom;
use App\Entities\Pledge;
use App\Entities\Participant;
use Faker\Factory as Faker;

class PledgeOMeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $referenceProgram = User::where('email', 'parent@example.com')->first()->participants[0]->getProgram();

        $myGroup = factory(Group::class)->create(['program_id' => $referenceProgram->id]);
        $myClassroom = factory(Classroom::class)->create(['group_id' => $myGroup->id]);

        $myParticipant = factory(Participant::class)->create([
            'classroom_id'  => $myClassroom->id
        ]);

        foreach (range(1, 2) as $c) {
            factory(Pledge::class)->create(
                [
                    'program_id'            => $referenceProgram->id,
                    'group_id'              => $myGroup->id,
                    'amount'                => $faker->randomFloat(2, 100, 1000),
                    'pledge_status_id'      => Pledge::CONFIRMED_STATUS,
                    'participant_user_id'   => $myParticipant->user_id
                ]
            );
        }
    }
}
