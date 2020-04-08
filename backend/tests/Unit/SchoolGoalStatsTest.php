<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Entities\Program;
use App\Entities\Pledge;
use App\Entities\PledgeType;
use App\Entities\User;
use App\Entities\StudentsParent;
use App\Entities\Participant;
use App\Entities\Group;
use App\Entities\Classroom;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Generator as Faker;

class SchoolGoalStatsTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function setUp() : void
    {
        parent::setUp();
        $this->parentUser = factory(User::class)->create();
        $this->program    = factory(Program::class)->create();
        // Refresh from database so that we get the default values (important for unit_flat_conversion)
        $this->program    = Program::find($this->program->id);
    }

    private function createPledge(int $laps = null)
    {
        return factory(Pledge::class)->create([
            'program_id'          => $this->program->id,
            'participant_user_id' => factory(User::class)->create(['laps' => $laps])->id,
            'pledge_status_id'    => $this->faker->randomElement([
                Pledge::CONFIRMED_STATUS,
                Pledge::PAID_STATUS,
                Pledge::PAID_PENDING_STATUS
            ])
        ]);
    }

    /**
     * Test if pledge total is accurate.
     *
     * @return void
     */
    public function testAccuratePledgeTotal()
    {
        $participantUsers[0] = factory(User::class)->create();
        $participantUsers[1] = factory(User::class)->create();
        $group               = factory(Group::class)->create(['program_id' => $this->program->id]);
        $classroom           = factory(Classroom::class)->create(['group_id' => $group->id]);

        // Associate participants with parent
        foreach ($participantUsers as $participantUser) {
            factory(StudentsParent::class)->create([
                'student_id' => $participantUser->id,
                'parent_id'  => $this->parentUser->id
            ]);
            factory(Participant::class)->create([
                'user_id'      => $participantUser->id,
                'classroom_id' => $classroom->id
            ]);
        }

        $totalCreatedPledgeAmount = 0;

        $lapCases = [
            null,
            0,
            $this->faker->numberBetween(1, 50),
            $this->faker->numberBetween(1, 50),
            $this->faker->numberBetween(1, 50)
        ];

        foreach ($lapCases as $laps) {
            $createdPledge = $this->createPledge($laps);

            if ($createdPledge->pledge_type_id != PledgeType::FLAT) {
                $totalCreatedPledgeAmount += ($createdPledge->amount * $this->program->unit_flat_conversion);
            } else {
                $totalCreatedPledgeAmount += $createdPledge->amount;
            }
        }

        $apiPledgeTotal = $this->actingAs($this->parentUser)
            ->get('/v3/api/programs-total-pledged/' . $this->program->id)
            ->assertStatus(200);

        $apiPledgeTotal = json_decode($apiPledgeTotal->getData());

        $this->assertEquals(round($totalCreatedPledgeAmount, 2), round($apiPledgeTotal, 2));
    }

    /**
     * Test hitting API endpoint without being in the program.
     *
     * @return void
     */
    public function testPledgeTotalUnauthorized()
    {
        $differentProgram = Program::where('id', '!=', $this->program->id)->first();

        if (! is_object($differentProgram)) {
            $this->assert(false);
        }

        $this->actingAs($this->parentUser)
            ->get('/v3/api/programs-total-pledged/' . $differentProgram->id)
            ->assertStatus(403);
    }
}
