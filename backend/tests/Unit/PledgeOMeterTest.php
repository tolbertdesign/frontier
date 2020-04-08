<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\User;
use App\Entities\Program;
use App\Entities\ProgramPledgeSetting;
use App\Entities\Group;
use App\Entities\Classroom;
use App\Entities\StudentsParent;
use App\Entities\Participant;
use App\Entities\Pledge;
use App\Entities\PledgeType;

class PledgeOMeterTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    const NUM_OF_PARTICIPANTS = 2;
    const NUM_OF_PLEDGES = 10;

    public $participants;
    public $parentUser;
    public $program;
    public $programPledgeSetting;
    public $classroomIds;
    public $testPledgeAmounts;
    public $pledges;

    public function setUp() : void
    {
        parent::setUp();

        $this->parentUser = factory(User::class)->create();
        $programCreate    = factory(Program::class)->create();
        $this->program    = Program::where('id', $programCreate->id)->first();
    }

    private function createParticipants(User $parentUser, int $numOfParicipants)
    {
        foreach (range(1, $numOfParicipants) as $v) {
            $group       = factory(Group::class)->create([
                'program_id' => $this->program->id
            ]);
            $classroom   = factory(Classroom::class)->create([
                'group_id' => $group->id
            ]);
            $participant = factory(Participant::class)->create(
                [
                    'classroom_id' => $classroom->id,
                    'user_id'     => factory(User::class)->create()
                ]
            );

            factory(StudentsParent::class)->create([
                'student_id' => $participant->user_id,
                'parent_id'  => $parentUser->id
            ]);

            $this->participants[] = $participant;
        }
    }

    private function createProgram(Participant $participant)
    {
        $testTotalPledged = 0;
        for ($x = 0; $x < self::NUM_OF_PLEDGES; $x++) {
            $pledgeAmount = $this->faker->randomFloat(2, 1, 10);
            $this->createPledge($participant->user_id, $pledgeAmount, $participant->classroom->group_id, $participant->classroom_id);
            $testTotalPledged += $pledgeAmount;
        }
        $this->classroomIds[]                                = $participant->classroom_id;
        $this->testPledgeAmounts[$participant->classroom_id] = $testTotalPledged;
    }

    /**
     * Add new pledge
     *
     * @return void
     */
    public function createPledge($participantUserId, $pledgeAmount, $groupId, $classroomId)
    {
        if (!array_key_exists($classroomId, $this->pledges)) {
            $this->pledges[$classroomId] = [];
        }

        $this->pledges[$classroomId][] = factory(Pledge::class)->create([
            'participant_user_id' => $participantUserId,
            'program_id'          => $this->program->id,
            'group_id'            => $groupId,
            'pledge_type_id'      => PledgeType::inRandomOrder()->first()->id,
            'pledge_status_id'    => $this->faker->randomElement([
                Pledge::CONFIRMED_STATUS,
                Pledge::PAID_STATUS,
                Pledge::PAID_PENDING_STATUS
            ]),
            'amount'              => $pledgeAmount
        ]);
    }

    /**
     * @return void
     */
    public function testValidTotalsForClassroomsInProgram()
    {
        $this->participants         = [];
        $this->parentUser           = factory(User::class)->create();
        $programCreate              = factory(Program::class)->create();
        $this->program              = Program::where('id', $programCreate->id)->first();
        $this->programPledgeSetting = factory(ProgramPledgeSetting::class)->create([
            'program_id' => $this->program->id,
        ]);
        $this->classroomIds         = [];
        $this->testPledgeAmounts    = [];
        $this->pledges              = [];

        $this->createParticipants($this->parentUser, self::NUM_OF_PARTICIPANTS);
        foreach ($this->participants as $participant) {
            $this->createProgram($participant);
        }

        $classrooms = $this->actingAs($this->parentUser)
            ->get('/v3/api/programs/classroom-pledge-totals/' . $this->program->id)
            ->assertStatus(200);

        $isFlatOnly = ($this->programPledgeSetting->flat_donate_only === 1);

        $this->assertTrue(!empty($classrooms) && !empty($classrooms->getData()));

        foreach ($classrooms->getData() as $classroom) {
            $totalPledgedAmount = 0;
            foreach ($this->pledges[$classroom->id] as $pledge) {
                if ($isFlatOnly) {
                    $totalPledgedAmount += $this->calculateFlatOnlyPledgeAmount($pledge);
                } else {
                    $totalPledgedAmount += $this->calculateMixedPledgeAmount($pledge);
                }
            }

            $this->assertEqualsWithDelta($classroom->pledgeTotal, $totalPledgedAmount, 0.01);
        }
    }

    private function calculateFlatOnlyPledgeAmount(Pledge $pledge)
    {
        if ($pledge->pledge_type_id === PledgeType::FLAT) {
            $totalPledgedAmount = $pledge->amount;
        } else {
            $participant = Participant::where('user_id', $pledge->participant_user_id)
                ->first();
            $totalPledgedAmount = $pledge->amount * $this->program->unit_flat_conversion;
        }

        return $totalPledgedAmount;
    }

    private function calculateMixedPledgeAmount(Pledge $pledge)
    {
        if ($pledge->pledge_type_id !== PledgeType::FLAT) {
            $totalPledgedAmount = $pledge->amount;
        } else {
            $participant = Participant::where('user_id', $pledge->participant_user_id)
                ->first();
            $totalPledgedAmount = $pledge->amount/$this->program->unit_flat_conversion;
        }

        return $totalPledgedAmount;
    }

    /**
     * Test hitting API endpoint without being in the program.
     *
     * @return void
     */
    public function testApiEndpointAuthorization()
    {
        $differentProgram = Program::where('id', '!=', $this->program->id)->first();
        if (! is_object($differentProgram)) {
            $this->assertTrue(false);
        }
        $this->actingAs($this->parentUser)
            ->get('/v3/api/programs/classroom-pledge-totals/' . $differentProgram->id)
            ->assertStatus(403);
    }
}
