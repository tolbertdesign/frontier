<?php

namespace Tests\Unit;

use App\Entities\Classroom;
use App\Entities\User;
use App\Models\RegisterModel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTypeTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testParentUserType()
    {
        $user = User::find(4);
        $userType = $user->getUserTypes();
        $this->assertEquals(array_pop($userType), 'Parent');
    }

    public function testRetreiveActiveParticipants()
    {
        $user = User::find(4);
        $participants = $user->getActiveParticipants();
        $this->assertEquals($participants->count(), 2);
    }

    public function testParentAllParticiapntsAreTeachers()
    {
        $user = User::find(4);
        $this->assertFalse($user->allParticipantsAreTeachers());
    }

    public function testParentHasNoActivePledge()
    {
        $user = User::find(4);
        $this->assertTrue($user->hasNoActivePledge());
    }

    public function testParentHasActiveParticipants()
    {
        $user = User::find(4);
        $this->assertTrue($user->hasActiveParticipants());
    }

    public function testTeacherUserType()
    {
        $user = $this->createTeacherUser();
        $userType = $user->getUserTypes();
        $this->assertEquals(array_pop($userType), 'Teacher');
    }

    public function testTeacherActiveParticipants()
    {
        $user = $this->createTeacherUser();
        $this->assertEquals($user->getActiveParticipants()->count(), 1);
    }

    public function testParticipantIsTeacher() {
        $user = $this->createTeacherUser();
        $participant = $user->participants->first();
        $this->assertTrue($participant->participantUserIsTeacher());
    }

    public function testNotAllParticipantsAreTeachers(){
        $user = $this->createTeacherUser();

        $participant = factory(User::class)->create(
            [
            'waiver_dob' => $this->faker->dateTimeBetween('1930-01-01', '2000-01-01'),
            'waiver_ts' => Carbon::now(),
            'waiver_signed' => 1,
            'active' => 1,
            'registered' => 1
            ]);

        $classroom = Classroom::skip(2)->first();
        $register = new RegisterModel();
        $register->createParticipant($participant, $user, $classroom, false, null);
        $this->assertFalse($user->allParticipantsAreTeachers());
    }


    public function testSponsorUserType()
    {
        $user = $this->createSponsorUser();
        $userType = $user->getUserTypes();
        $this->assertEquals(array_pop($userType), 'Sponsor');
    }

    public function testOrgAdminUserType()
    {
        $user = $this->createOrgAdminUser();
        $userType = $user->getUserTypes();
        $this->assertEquals(array_pop($userType), 'Org Admin');
    }

    public function testSuperAdminUserType()
    {
        $user = $this->createSuperAdminUser();
        $userType = $user->getUserTypes();
        $this->assertEquals(array_pop($userType), 'Super Admin');
    }

    public function testAdminUserType()
    {
        $user = $this->createAdminUser();
        $userType = $user->getUserTypes();
        $this->assertEquals(array_pop($userType), 'Admin');
    }

    public function testVolunteerUserType()
    {
        $user = $this->createVolunteerUser();
        $userType = $user->getUserTypes();
        $this->assertEquals(array_pop($userType), 'Volunteer');
    }
}
