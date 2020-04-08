<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\User;
use App\Entities\Pledge;
use App\Entities\Group;
use App\Entities\Program;
use App\Entities\Classroom;
use App\Entities\Participant;
use App\Models\RegisterModel;
use App\Entities\PledgeType;
use Illuminate\Foundation\Testing\WithFaker;

class TeacherPledgeMeterTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function setUp() : void
    {
        parent::setUp();

        $this->teacherUser            = User::where('email', 'teacher@example.com')->first();
        $this->teacherParticipantUser = $this->teacherUser->teacherParticipant();
    }

    public function testIsTeacherUser()
    {
        config(['system_control.status' => true]);
        config(['system_control.titan_dashboard.route_to_titan_teacher_dashboard' => 'on']);
        $result = $this->actingAs($this->teacherUser)
            ->withSession(['parent_dashboard' => true])
            ->get('/v3/home/teacher-dashboard-user')
            ->assertStatus(200);

        $response = $result->json();
        $this->assertEquals($response['is_teacher_user'], '1');
    }

    public function testLastName()
    {
        config(['system_control.status' => true]);
        config(['system_control.titan_dashboard.route_to_titan_teacher_dashboard' => 'on']);
        $result = $this->actingAs($this->teacherUser)
            ->withSession(['parent_dashboard' => true])
            ->get('/v3/home/teacher-dashboard-user')
            ->assertStatus(200);

        $response = $result->json();
        $this->assertEquals($response['class_last_name'], $this->teacherUser->last_name);
    }

    private function createFreshPledgesScenario()
    {
        $program    = factory(Program::class)->create();
        $group      = factory(Group::class)->create([
            'program_id' => $program->id
        ]);
        $classroom  = factory(Classroom::class)->create([
            'group_id' => $group->id
        ]);
        $teacherUser = $this->createTeacher($classroom);
        $this->createPledge($program, $classroom, 100, 1);
        $this->createPledge($program, $classroom, 50);
        return $teacherUser;
    }

    public function testPledgeTotals()
    {
        config(['system_control.status' => true]);
        config(['system_control.titan_dashboard.route_to_titan_teacher_dashboard' => 'on']);
        $teacherUser = $this->createFreshPledgesScenario();

        $result = $this->actingAs($teacherUser)
            ->withSession(['parent_dashboard' => true])
            ->get('/v3/home/teacher-dashboard-user')
            ->assertStatus(200);

        $response       = $result->json();
        $expectedAmount = 5;
        $this->assertEquals(round($response['class_pledge_total'], 2), round($expectedAmount, 2));
    }

    private function createTeacher(Classroom $classroom)
    {
        $user             = factory(User::class)->create([
            'first_name'    => 'teacherpledgemetertest',
            'last_name'     => 'teacherpledgemetertest',
            'email'         => 'teacherpledgemetertest@example.com',
            'username'      => 'teacherpledgemetertest@example.com',
        ]);

        $registerModel = new RegisterModel();
        $teacher       = $registerModel->registerTeacher($user, $classroom->team_leader_code);
        $teacher->parents()->save($user);

        return $user;
    }

    private function createPledge($program, Classroom $classroom, int $amount, int $laps = null)
    {
        $participantUser = factory(User::class)->create(['laps' => $laps]);
        factory(Participant::class)->create([
            'user_id'       => $participantUser->id,
            'classroom_id'  => $classroom->id
        ]);

        return factory(Pledge::class)->create([
            'program_id'          => $program->id,
            'participant_user_id' => $participantUser->id,
            'amount'              => $amount,
            'pledge_type_id'      => PledgeType::FLAT,
            'pledge_status_id'    => $this->faker->randomElement([
                Pledge::CONFIRMED_STATUS,
                Pledge::PAID_STATUS,
                Pledge::PAID_PENDING_STATUS
            ])
        ]);
    }
}
