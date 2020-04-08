<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Classroom;
use App\Entities\Group;
use App\Entities\User;
use App\Models\RegisterModel;
use App\Entities\PrizesBound;
use App\Entities\Program;
use Illuminate\Support\Facades\Storage;
use App\Models\StudentStarModel;
use Illuminate\Support\Facades\Queue;
use Lang;

class ParticipantRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    private $parentUser;
    private $user;
    private $classroom;

    public function setUp(): void
    {
        parent::setUp();
        Queue::fake();

        $this->parentUser = factory(User::class)->create();
        $this->user       = factory(User::class)->create();
        $this->classroom  = Classroom::first();
        $registerModel    = new RegisterModel();
        $registerModel->createParticipant($this->user, $this->parentUser, $this->classroom, false, null);
    }

    /** @test */
    public function ValidParticipantRegistration()
    {
        $this->assertEquals($this->user->participantInfo()->first()->classroom->id, $this->classroom->id);
    }

    /** @test */
    public function ValidPrizeTest()
    {
        $parentUser          = factory(User::class)->create();
        $user                = factory(User::class)->create();
        $classroom           = factory(Classroom::class)->make();
        $classroom->group_id = 9775;
        $classroom->save();
        $registerModel       = new RegisterModel();
        $registerModel->createParticipant($user, $parentUser, $classroom, false, null);
        $randomPrize = PrizesBound::where('group_id', 9775)->inRandomOrder()->first()->prize;

        $this->assertTrue($randomPrize->name === $user->prizes->where('id', $randomPrize->id)->first()->name);
    }

    /** @test */
    public function registerParticipantWithImageWithSsvEnabledTest()
    {
        Storage::fake();
        $fakeImage           = UploadedFile::fake()->image('photo1.jpg');
        $parentUser          = factory(User::class)->create();
        $user                = factory(User::class)->create();
        $program             = factory(Program::class)->create([
            'ssv_disabled' => 0
        ]);
        $group               = factory(Group::class)->create([
            'program_id' => $program->id
        ]);
        $classroom           = factory(Classroom::class)->create([
            'group_id' => $group->id
        ]);
        $registerModel       = new RegisterModel();
        $registerModel->createParticipant($user, $parentUser, $classroom, false, $fakeImage);

        $this->assertEquals($user->participantInfo()->first()->classroom->id, $classroom->id);
    }

    /** @test */
    public function registerParticipantWithImageWithSsvDisabledTest()
    {
        Storage::fake();
        $fakeImage           = UploadedFile::fake()->image('photo1.jpg');
        $parentUser          = factory(User::class)->create();
        $user                = factory(User::class)->create();
        $program             = factory(Program::class)->create([
            'ssv_disabled' => 1
        ]);
        $group               = factory(Group::class)->create([
            'program_id' => $program->id
        ]);
        $classroom           = factory(Classroom::class)->create([
            'group_id' => $group->id
        ]);
        $registerModel       = new RegisterModel();
        $registerModel->createParticipant($user, $parentUser, $classroom, false, $fakeImage);

        $this->assertEquals($user->participantInfo()->first()->classroom->id, $classroom->id);
    }

    /** @test */
    public function setFamilyPledgingWithFamilyPledgingDisabledTest()
    {
        $program = Program::first();

        $program->programPledgeSetting->family_pledging_enabled = 0;

        $registerModel = new RegisterModel();
        $method        = $registerModel->setFamilyPledgingStatusForParticipant($this->parentUser, $program);
        $this->assertFalse($method);
    }

    /** @test */
    public function setFamilyPledgingWithNoParticipantsTest()
    {
        $program                                                = Program::first();
        $program->programPledgeSetting->family_pledging_enabled = 1;
        $program->save();

        $user               = $this->parentUser;
        $user->participants = collect();
        $registerModel      = new RegisterModel();
        $method             = $registerModel->setFamilyPledgingStatusForParticipant($user, $program);
        $this->assertFalse($method);
    }

    /** @test */
    public function setFamilyPledgingForTeacher()
    {
        $user  = User::where('email', 'parent@example.com')->first();
        $user->participants[0]->assignRole('teachers');

        $program = $user->participants[0]->getProgram();
        $program->programPledgeSetting->family_pledging_enabled = 1;
        $program->save();

        $registerModel = new RegisterModel();
        $method        = $registerModel->setFamilyPledgingStatusForParticipant($user, $program);
        $this->assertTrue($method);
    }

    /** @test */
    public function setFamilyPledgingForParticipantsTest()
    {
        $user = User::where('email', 'parent@example.com')->first();

        $user->participants = $user->participants->each(function ($participantUser) {
            $participantUser->assignRole('teachers');
        });
        $program = $user->participants[0]->getProgram();
        $program->programPledgeSetting->family_pledging_enabled = 1;
        $program->save();

        $registerModel = new RegisterModel();
        $method        = $registerModel->setFamilyPledgingStatusForParticipant($user, $program);
        $this->assertFalse($method);
    }

    /** @test */
    public function studentStarWithBadImageTest()
    {
        $studentStarModel = new StudentStarModel();
        $createJob        = $studentStarModel->createJob('', $this->user->id, $this->user->first_name, $this->user->getSchoolAttribute());
        $this->assertNull($createJob);
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function studentStarCancelJobTest()
    {
        $mock = $this->getMockBuilder(StudentStarModel::class)
            ->setMethods(['sendRequest'])
            ->getMock();

        $mock->expects($this->once())
            ->method('sendRequest');

        $mock->cancelJobsBy($this->user->id);
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function studentStarSendDeleteRequestTest()
    {
        $mock = $this->getMockBuilder(StudentStarModel::class)
            ->setMethods(['getEndpoint'])
            ->getMock();

        $mock->method('getEndpoint');

        $result = $mock->sendRequest('delete test', 'DELETE', ['test']);
        $this->assertFalse($result);
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function studentStarSendFakeRequestTest()
    {
        $mock = $this->getMockBuilder(StudentStarModel::class)
            ->setMethods(['getEndpoint'])
            ->getMock();

        $mock->method('getEndpoint');

        $result = $mock->sendRequest('FAKE test', 'FAKE', ['test']);
        $this->assertFalse($result);
    }

    /** @test */
    public function registrationWithInvalidTeacherRegistrationCodeTest()
    {
        $registerModel = new RegisterModel();
        $method        = $registerModel->validateTeacherRegistrationCode('invalid code');

        $this->assertEquals(Lang::get('register.invalid_teacher_code'), $method['message']);
        $this->assertEquals(false, $method['success']);
    }

    /** @test */
    public function registrationWithValidTeacherRegistrationCodeTest()
    {
        $classroom = Classroom::first();
        $classroom->teacher_3_id = null;
        $classroom->save();

        $registerModel = new RegisterModel();
        $method        = $registerModel->validateTeacherRegistrationCode($classroom->team_leader_code);

        $this->assertEquals('', $method['message']);
        $this->assertEquals(true, $method['success']);
    }

    /** @test */
    public function registrationWithValidTeacherRegistrationCodeButClassFullTest()
    {
        $classroom               = Classroom::first();
        $classroom->teacher_id   = 1;
        $classroom->teacher_2_id = 2;
        $classroom->teacher_3_id = 3;
        $classroom->save();

        $registerModel = new RegisterModel();
        $method        = $registerModel->validateTeacherRegistrationCode($classroom->team_leader_code);

        $this->assertEquals(Lang::get('register.max_teachers_reached'), $method['message']);
        $this->assertEquals(false, $method['success']);
    }
}
