<?php

namespace Tests\Unit;

use App\Entities\User;
use App\Entities\UserTask;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Carbon\Carbon;

class UserTaskControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->teacherUser = User::where('email', 'teacher@example.com')->first();
        $this->teacherParticipant = $this->teacherUser->teacherParticipant();
        $programId = $this->teacherParticipant->classroom->first()->group->program->id;
        $this->userTask = factory(UserTask::class)->create([
            'program_id'          => $programId,
            'assigned_to_user_id' => $this->teacherParticipant->id,
            'type'                => 'Teacher',
            'created_by_user_id'  => $this->teacherParticipant->id,
        ]);
    }

    public function testSetTaskAsComplete()
    {
        $expectedDate = Carbon::now();
        $this->userTask->completed_on_date = $expectedDate;

        $response = $this->actingAs($this->teacherUser)
            ->put('/v3/api/user-task/' . $this->userTask->id, $this->userTask->toArray())
            ->assertStatus(200);

        $this->userTask->refresh();

        $this->assertEquals($this->userTask->completed_by_user_id, $this->teacherUser->id);
    }

    public function testSetTaskAsIncomplete()
    {
        $this->userTask->completed_on_date = null;

        $response = $this->actingAs($this->teacherUser)
            ->put('/v3/api/user-task/' . $this->userTask->id, $this->userTask->toArray())
            ->assertStatus(200);

        $this->userTask->refresh();
        $this->assertEquals($this->userTask->completed_on_date, null);
    }

    public function testSetTaskAsIncompleteByWrongUser()
    {
        $this->userTask->completed_on_date = null;

        $parentUser = User::where('email', 'parent@example.com')->first();
        $response = $this->actingAs($parentUser)
            ->put('/v3/api/user-task/' . $this->userTask->id, [$this->userTask])
            ->assertStatus(403);
    }
}
