<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\User;
use App\Entities\Participant;
use App\Entities\AccessToken;
use App\Entities\Classroom;
use App\Entities\Group;
use App\Entities\Pledge;
use App\Entities\Program;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    private $user;
    private $loginInfo;
    private $loginRedirect = '/v3/home/dashboard';
    private $dashboardUrl  = 'home/dashboard';
    private $password      = 'password';
    private $sponsorPage   = 'my_pledges';

    public function setUp() : void
    {
        parent::setUp();
        $this->user = factory(User::class)->create([
            'password' => password_hash($this->password, PASSWORD_DEFAULT)
        ]);

        $this->loginInfo = [
            'email'    => $this->user->email,
            'password' => $this->password
        ];
    }

    /**
     * @group parent
     * @test
     */
    public function testLoggingInAsParentWithoutParticipantOrPledge()
    {
        $this->makeUserParent();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group sponsor
     * @test
     */
    public function testLoggingInAsSponsorWithoutParticipantOrPledge()
    {
        $this->makeUserSponsor();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group orgAdmin
     * @test
     */
    public function testLoggingInAsOrgAdminWithoutParticipantOrPledge()
    {
        $this->makeUserOrgAdmin();
        $this->assertionsForWelcomeBackPage();
    }

    /**
     * @group superAdmin
     * @test
     */
    public function testLoggingInAsSuperAdminWithoutParticipantOrPledge()
    {
        $this->makeUserSuperAdmin();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group admin
     * @test
     */
    public function testLoggingInAsAdminWithoutParticipantOrPledge()
    {
        $this->makeUserAdmin();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group parent
     * @test
     */
    public function testLoggingInAsParentWithParticipantInOpenProgram()
    {
        $this->makeUserParent();
        $this->addParticipant();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group sponsor
     * @test
     */
    public function testLoggingInAsSponsorWithParticipantInOpenProgram()
    {
        $this->makeUserSponsor();
        $this->addParticipant();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group parent
     * @test
     */
    public function testLoggingInAsParentWithParticipantInFinishedProgramWithLaps()
    {
        $this->makeUserParent();
        $this->addParticipantInFinishedFunrun();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group parent
     * @test
     */
    public function testLoggingInAsParentWithParticipantInFinishedProgramWithoutLaps()
    {
        $this->makeUserParent();
        $this->addParticipantInFinishedFunrun(false);
        $this->assertionsForTkRedirect();
    }

    /**
     * @group orgAdmin
     * @test
     */
    public function testLoggingInAsOrgAdminWithParticipant()
    {
        $this->makeUserOrgAdmin();
        $this->addParticipant();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group superAdmin
     * @test
     */
    public function testLoggingInAsSuperAdminWithParticipant()
    {
        $this->makeUserSuperAdmin();
        $this->addParticipant();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group admin
     * @test
     */
    public function testLoggingInAsAdminWithParticipant()
    {
        $this->makeUserAdmin();
        $this->addParticipant();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group parent
     * @test
     */
    public function testLoggingInAsParentWithPledge()
    {
        $this->makeUserParent();
        $this->addPledge();
        $this->assertionsForWelcomeBackPage();
    }

    /**
     * @group sponsor
     * @test
     */
    public function testLoggingInAsSponsorWithPledge()
    {
        $this->makeUserSponsor();
        $this->addPledge();
        $this->assertionsForTkRedirect($this->sponsorPage);
    }

    /**
     * @group orgAdmin
     * @test
     */
    public function testLoggingInAsOrgAdminWithPledge()
    {
        $this->makeUserOrgAdmin();
        $this->addPledge();
        $this->assertionsForWelcomeBackPage();
    }

    /**
     * @group superAdmin
     * @test
     */
    public function testLoggingInAsSuperAdminWithPledge()
    {
        $this->makeUserSuperAdmin();
        $this->addPledge();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group admin
     * @test
     */
    public function testLoggingInAsAdminWithPledge()
    {
        $this->makeUserAdmin();
        $this->addPledge();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group parent
     * @test
     */
    public function testLoggingInAsParentWithArchivedParticipant()
    {
        $this->makeUserParent();
        $this->addArchivedParticipant();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group sponsor
     * @test
     */
    public function testLoggingInAsSponsorWithArchivedParticipant()
    {
        $this->makeUserSponsor();
        $this->addArchivedParticipant();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group orgAdmin
     * @test
     */
    public function testLoggingInAsOrgAdminWithArchivedParticipant()
    {
        $this->makeUserOrgAdmin();
        $this->addArchivedParticipant();
        $this->assertionsForWelcomeBackPage();
    }

    /**
     * @group superAdmin
     * @test
     */
    public function testLoggingInAsSuperAdminWithArchivedParticipant()
    {
        $this->makeUserSuperAdmin();
        $this->addArchivedParticipant();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group admin
     * @test
     */
    public function testLoggingInAsAdminWithArchivedParticipant()
    {
        $this->makeUserAdmin();
        $this->addArchivedParticipant();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group parent
     * @test
     */
    public function testLoggingInAsParentWithPledgeInArchivedProgram()
    {
        $this->makeUserParent();
        $this->addPledgeInArchivedProgram();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group sponsor
     * @test
     */
    public function testLoggingInAsSponsorWithPledgeInArchivedProgram()
    {
        $this->makeUserSponsor();
        $this->addPledgeInArchivedProgram();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * @group orgAdmin
     * @test
     */
    public function testLoggingInAsOrgAdminWithPledgeInArchivedProgram()
    {
        $this->makeUserOrgAdmin();
        $this->addPledgeInArchivedProgram();
        $this->assertionsForWelcomeBackPage();
    }

    /**
     * @group superAdmin
     * @test
     */
    public function testLoggingInAsSuperAdminWithPledgeInArchivedProgram()
    {
        $this->makeUserSuperAdmin();
        $this->addPledgeInArchivedProgram();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group admin
     * @test
     */
    public function testLoggingInAsAdminWithPledgeInArchivedProgram()
    {
        $this->makeUserAdmin();
        $this->addPledgeInArchivedProgram();
        $this->assertionsForTkRedirect();
    }

    /**
     * @group volunteer
     * @test
     */
    public function testLoggingInAsVolunteer()
    {
        $this->makeUserVolunteer();
        $this->assertionsForTkRedirect('/admin/schools');
    }

    /**
     * @group boosterthon
     * @test
     */
    public function testLoggingInWithBoosterthonEmail()
    {
        $this->makeUserHaveBoosterthonEmail();
        $this->assertionsForTkRedirect();
    }

    /**
     * @test
     */
    public function testLoginPostSuccess()
    {
        $this->assertInitialRedirectToDashboard();

        $secondRedirect = $this->actingAs($this->user)
            ->get($this->loginRedirect)
            ->assertStatus(302);

        // User redirects to welcome page to complete profile
        $secondRedirect->assertRedirect(secure_url('/v3'));
    }

    /**
     * @group orgAdmin
     * @test
     */
    public function testTkAdminRedirectForOrgAdminWithoutParticipantOrPledge()
    {
        $this->makeUserOrgAdmin();

        $secondRedirect = $this->actingAs($this->user)
            ->withSession(['is_org_admin' => true])
            ->get('v3/tkdashboard?redirect=admin')
            ->assertStatus(302);

        $token = AccessToken::where('user_id', $this->user->id)
            ->orderBy('id', 'desc')->first();

        $redirect = secure_url('/login-titan/' . $this->user->id . '/' . $token->access_token);

        $secondRedirect->assertRedirect($redirect);
        $this->assertSame('admin', $token->redirect);
    }

    public function assertInitialRedirectToDashboard()
    {
        // Ensure cookie isn't set from somewhere else
        Cookie::forget('parent_dashboard');

        $this->actingAs($this->user)
            ->post('/v3/login', $this->loginInfo)
            ->assertStatus(302)
            ->assertRedirect($this->loginRedirect);
    }

    public function assertionsForTkRedirect($redirectValue = null)
    {
        $this->assertInitialRedirectToDashboard();

        // Ensure cookie isn't set from somewhere else
        Cookie::forget('parent_dashboard');

        $secondRedirect = $this->actingAs($this->user)
            ->get($this->loginRedirect)
            ->assertStatus(302);

        $token = AccessToken::where('user_id', $this->user->id)
            ->orderBy('id', 'desc')->first();

        $redirect = secure_url('/login-titan/' . $this->user->id . '/' . $token->access_token);

        $secondRedirect->assertRedirect($redirect);
        $this->assertSame($redirectValue, $token->redirect);
    }

    public function assertionsForWelcomeBackPage()
    {
        $this->assertInitialRedirectToDashboard();

        // Ensure cookie isn't set from somewhere else
        Cookie::forget('parent_dashboard');

        $this->actingAs($this->user)
            ->get($this->loginRedirect)
            ->assertStatus(302)
            ->assertRedirect('/v3');
    }

    public function makeUserParent()
    {
        DB::table('users_user_groups')->insert([
            'user_id'  => $this->user->id,
            'group_id' => User::PARENT_USERS_GROUP_ID
        ]);
    }

    public function makeUserOrgAdmin()
    {
        DB::table('users_user_groups')->insert([
            'user_id'  => $this->user->id,
            'group_id' => User::ORG_ADMIN_USERS_GROUP_ID
        ]);
    }

    public function makeUserSuperAdmin()
    {
        DB::table('users_user_groups')->insert([
            'user_id'  => $this->user->id,
            'group_id' => User::SUPER_ADMIN_USERS_GROUP_ID
        ]);
    }

    public function makeUserAdmin()
    {
        DB::table('users_user_groups')->insert([
            'user_id'  => $this->user->id,
            'group_id' => User::ADMIN_USERS_GROUP_ID
        ]);
    }

    public function makeUserVolunteer()
    {
        DB::table('users_user_groups')->insert([
            'user_id'  => $this->user->id,
            'group_id' => User::VOLUNTEER_USERS_GROUP_ID
        ]);
    }

    public function makeUserSponsor()
    {
        DB::table('users_user_groups')->insert([
            'user_id'  => $this->user->id,
            'group_id' => User::SPONSOR_USERS_GROUP_ID
        ]);
    }

    public function addParticipant()
    {
        $program = factory(Program::class)->create([
            'fun_run'  => Carbon::tomorrow(),
            'archived' => 0
        ]);

        $group = factory(Group::class)->create([
            'program_id' => $program->id
        ]);

        $classroom = factory(Classroom::class)->create([
            'group_id' => $group->id
        ]);

        $participantUser = factory(User::class)->create();

        factory(Participant::class)->create([
            'user_id'      => $participantUser->id,
            'classroom_id' => $classroom->id
        ]);

        DB::table('students_parents')->insert([
            'student_id' => $participantUser->id,
            'parent_id'  => $this->user->id
        ]);
    }

    public function addParticipantInFinishedFunrun($hasLaps = true)
    {
        $program = factory(Program::class)->create([
            'fun_run' => Carbon::yesterday()
        ]);

        $group = factory(Group::class)->create([
            'program_id' => $program->id
        ]);

        $classroom = factory(Classroom::class)->create([
            'group_id' => $group->id
        ]);

        $participantUser = factory(User::class)->create([
            'laps' => $hasLaps ? 30 : null
        ]);

        factory(Participant::class)->create([
            'user_id'      => $participantUser->id,
            'classroom_id' => $classroom->id
        ]);

        DB::table('students_parents')->insert([
            'student_id' => $participantUser->id,
            'parent_id'  => $this->user->id
        ]);
    }

    public function addArchivedParticipant()
    {
        $program = factory(Program::class)->create([
            'fun_run'  => Carbon::yesterday(),
            'archived' => 1
        ]);

        $group = factory(Group::class)->create([
            'program_id' => $program->id
        ]);

        $classroom = factory(Classroom::class)->create([
            'group_id' => $group->id
        ]);

        $participantUser = factory(User::class)->create([
            'laps' => 0
        ]);

        factory(Participant::class)->create([
            'user_id'      => $participantUser->id,
            'classroom_id' => $classroom->id
        ]);

        DB::table('students_parents')->insert([
            'student_id' => $participantUser->id,
            'parent_id'  => $this->user->id
        ]);
    }

    public function addPledgeInArchivedProgram()
    {
        $program = factory(Program::class)->create([
            'archived' => 1
        ]);

        factory(Pledge::class)->create([
            'user_id'    => $this->user->id,
            'program_id' => $program->id
        ]);
    }

    public function addPledge()
    {
        $program = factory(Program::class)->create([
            'archived' => 0
        ]);

        factory(Pledge::class)->create([
            'user_id'    => $this->user->id,
            'program_id' => $program->id
        ]);
    }

    /**
     * Set user email to boosterthon email address.
     *
     * @return  void
     */
    public function makeUserHaveBoosterthonEmail()
    {
        $this->user->email = 'parent-' . time() . '@boosterthon.com';
        $this->user->save();

        $this->user->refresh();
    }

    /**
     * @group teacher
     * @test
     */
    public function testLoggingInAsTeacherWithoutParticipants()
    {
        $this->makeUserATeacher();
        config(['system_control.status' => true]);
        config(['system_control.titan_dashboard.route_to_titan_teacher_dashboard' => 'parity']);
        if ($this->user->id % 2 === 1) {
            $this->assertionsForTeacher();
        } else {
            $this->assertInitialRedirectToDashboard();
        }
    }

    /**
     * @group teacher
     * @group parent
     * @test
     */
    public function testLoggingInAsTeacherWithActiveParticipants()
    {
        $this->makeUserATeacher();
        $this->addParticipant();
        $this->assertInitialRedirectToDashboard();
    }

    /**
     * Assert that the teacher redirects to the teacher dashboard
     *
     * @return void
     */
    public function assertionsForTeacher()
    {
        $this->assertInitialRedirectToDashboard();

        $this->actingAs($this->user)
            ->get($this->loginRedirect)
            ->assertStatus(302)
            ->assertRedirect('/v3/home/teacher-dashboard');
    }

    /**
     * Set user to default teacher user
     *
     * @return  void
     */
    public function makeUserATeacher()
    {
        $this->user = User::where('email', 'teacher@example.com')->first();
    }
}
