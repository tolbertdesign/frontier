<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\School;
use App\Entities\User;
use Illuminate\Support\Carbon;
use App\Libraries\FrCodeGenerator;
use App\Entities\Classroom;
use App\Entities\PrizesBoundStudent;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\UserTask;
use App\Http\Controllers\Auth\RegisterController;
use App\Jobs\BindParticipantPrizes;
use App\Models\RegisterModel;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Queue;
use Mockery;
use ReflectionClass;
use App\Facades\FeatureFlag;
use App\Jobs\AddUserNotifications;
use Auth;

/** @group register */
class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function searchSchoolsValid()
    {
        $this->mockNotificationFeatureFlag(false);

        $school                = School::first();
        $program               = $school->programs->first();
        $program->pledging_end = Carbon::tomorrow();
        $program->save();

        $this->get('/v3/api/schools/' . substr($school->name, 0, 5))
            ->assertJsonFragment(['name' => $school->name]);
    }

    /** @test */
    public function searchSchoolInvalid()
    {
        $this->mockNotificationFeatureFlag(false);

        $response = $this->get('/v3/api/schools/1ti10f12');
        $response->assertExactJson([]);
    }

    /** @test */
    public function registrationCodeIsValid()
    {
        $this->mockNotificationFeatureFlag(false);

        $school   = School::first();
        $program  = $school->programs->first();
        $program->pledging_end = Carbon::tomorrow();
        $program->save();

        $this->get('/v3/api/schools/registration-code/' . $program->registration_code)
            ->assertJsonFragment([
                'name'  => $school->name,
                'city'  => $school->city,
                'state' => $school->state
            ]);
    }

    /** @test */
    public function registrationCodeIsInvalid()
    {
        $this->mockNotificationFeatureFlag(false);

        $this->get('/v3/api/schools/registration-code/10f023fj0234fj0293jf')
            ->assertExactJson(['error' => Lang::get('register.invalid_code')]);
    }

    /** @test */
    public function prizesBoundToUserOk()
    {
        $this->mockNotificationFeatureFlag(false);

        $participantUser = User::create(
            [
                'first_name'  => 'PrizeBountTest',
                'last_name'   => 'PrizeboundTest',
                'email'       => 'prizeboundtest@boosterthon.com',
                'username'    => 'prizebounttest@boosterthon.com',
                'password'    => bcrypt('Secret1!'),
                'created_on'  => time(),
                'active'      => 1,
                'phone'       => '5551231234',
                'dob'         => Carbon::createFromDate(1980, 12, 20),
                'fr_code'     => FrCodeGenerator::generate(),
            ]
        );

        $classroom = Classroom::first();
        $participantUser->classroom()->save($classroom);

        $participantUser->bindNewParticipantPrizes();

        $studentsPrizes     = PrizesBoundStudent::where('student_id', '=', $participantUser->id)->get()->count();
        $numClassroomPrizes = $classroom->group->prizesBound->count();
        $this->assertEquals($studentsPrizes, $numClassroomPrizes);
    }

    /** @test */
    public function tasksBoundToUserOk()
    {
        $this->mockNotificationFeatureFlag(false);

        $parentUserData = [
                'first_name'                => 'tasksBoundTest',
                'last_name'                 => 'tasksBoundTest',
                'email'                     => 'tasksBoundTest@boosterthon.com',
                'username'                  => 'tasksBoundTest@boosterthon.com',
                'teacher_registration_code' => '39018685',
                'password'                  => bcrypt('Secret1!'),
                'created_on'                => time(),
                'active'                    => 1,
                'phone'                     => '5551231234',
                'year'                      => '1980',
                'month'                     => '12',
                'day'                       => '20',
                'fr_code'                   => FrCodeGenerator::generate(),
                'marketing_opt_in'          => true,
        ];
        $registerModel  = new RegisterModel();
        $parentUser     = $registerModel->registerParent($parentUserData);
        $teacherUser    = $registerModel->registerTeacher($parentUser, $parentUserData['teacher_registration_code']);
        $teacherTasks   = UserTask::where('assigned_to_user_id', '=', $teacherUser->id)->get()->count();
        $numConfigTasks = count(config('tasks.teacher_checklist'));
        $this->assertEquals($teacherTasks, $numConfigTasks);
    }

    /** @test */
    public function UnregisteredEmailAddressValidation()
    {
        $this->mockNotificationFeatureFlag(false);

        $this->post('/v3/api/register/email-address', ['emailAddress'=>factory(User::class)->make()->email])
            ->assertJsonFragment(['email_available' => true]);
    }

    /** @test */
    public function registeredEmailAddressValidation()
    {
        $this->mockNotificationFeatureFlag(false);

        $this->post('/v3/api/register/email-address', ['emailAddress'=> User::first()->email])
            ->assertJsonFragment(['email_available' => false]);
    }

    /** @test */
    public function invalidEmailAddressRegistration()
    {
        $this->mockNotificationFeatureFlag(false);

        $this->json('POST', '/v3/api/register/email-address', ['emailAddress' => 'asdf2'])
            ->assertJsonValidationErrors('emailAddress');
    }

    /** @test */
    public function testRegisterTeacherMethodAfterRegisteringTheMaximumOfThreeTeachers()
    {
        $this->mockNotificationFeatureFlag(false);

        $teacherUsers  = User::limit(3)->get();
        $classroom     = factory(Classroom::class)->create();
        $registerModel = new RegisterModel();
        $user          = factory(User::class)->make();

        for ($i = 0; $i < 3; $i++) {
            $registerModel->saveTeacherToClassroom($teacherUsers[$i], $classroom);
        }

        $this->assertFalse($registerModel->registerTeacher($user, $classroom->team_leader_code));
    }

    /** @test */
    public function addingMoreThanThreeTeachersToAClassroom()
    {
        $this->mockNotificationFeatureFlag(false);

        $teacherUsers  = User::limit(4)->get();
        $classroom     = factory(Classroom::class)->create();
        $registerModel = new RegisterModel();

        // There are only 3 slots for teachers so the 4th teacher should return false
        for ($i = 0; $i < 4; $i++) {
            if ($i < 3) {
                $this->assertTrue($registerModel->saveTeacherToClassroom($teacherUsers[$i], $classroom));
            } else {
                $this->assertFalse($registerModel->saveTeacherToClassroom($teacherUsers[$i], $classroom));
            }
        }
    }

    /**
     * A unit test for the create method.
     *
     * @return  Void
     */
    public function testCreateMethod()
    {
        $this->mockNotificationFeatureFlag(false);

        $time       = time();
        $fr_code    = FrCodeGenerator::generate();
        $reflection = self::getMethod('create');
        $controller = new RegisterController();
        $result     = $reflection->invokeArgs($controller, [[
            'first_name' => 'firstName',
            'last_name'  => 'lastName',
            'email'      => 'email@example.com',
            'username'   => 'email@example.com',
            'password'   => bcrypt('Secret1!'),
            'created_on' => $time,
            'active'     => 1,
            'phone'      => '1234567890',
            'year'       => 1980,
            'month'      => 12,
            'day'        => 20,
            'dob'        => Carbon::createFromDate(1980, 12, 20),
            'fr_code'    => $fr_code,
        ]]);

        $this->assertSame($result->first_name, 'firstName');
        $this->assertSame($result->last_name, 'lastName');
        $this->assertSame($result->email, 'email@example.com');
        $this->assertSame($result->created_on, $time);
        $this->assertSame($result->active, 1);
        $this->assertSame($result->phone, '1234567890');
        $this->assertContains('1980-12-20', (string)$result->dob);
    }

    // Reflection used for testing a protected method
    protected static function getMethod($name) {
        $class = new ReflectionClass(RegisterController::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testPrizeCreationOnPrizeCreationFailure() {
        $this->mockNotificationFeatureFlag(false);

        $participantUser = User::create(
            [
                'first_name'  => 'PrizeBountTest',
                'last_name'   => 'PrizeboundTest',
                'email'       => 'prizeboundtest@boosterthon.com',
                'username'    => 'prizebounttest@boosterthon.com',
                'password'    => bcrypt('Secret1!'),
                'created_on'  => time(),
                'active'      => 1,
                'phone'       => '5551231234',
                'dob'         => Carbon::createFromDate(1980, 12, 20),
                'fr_code'     => FrCodeGenerator::generate(),
            ]
        );

        $parentUser = User::find(4);

        $classroom = Classroom::first();
        Queue::fake();

        $registerModel = Mockery::mock(RegisterModel::class)->makePartial()->shouldAllowMockingProtectedMethods();
                $registerModel->shouldReceive('bindNewParticipantPrizesNow')
                ->once()
                ->andThrow(new Exception);
        $registerModel->createParticipant($participantUser, $parentUser, $classroom, false, null);
        Queue::assertPushed(BindParticipantPrizes::class);

    }

    public function testPrizeCreationWithoutPrizeCreation() {
        $this->mockNotificationFeatureFlag(false);

        $participantUser = User::create(
            [
                'first_name'  => 'PrizeBountTest',
                'last_name'   => 'PrizeboundTest',
                'email'       => 'prizeboundtest@boosterthon.com',
                'username'    => 'prizebounttest@boosterthon.com',
                'password'    => bcrypt('Secret1!'),
                'created_on'  => time(),
                'active'      => 1,
                'phone'       => '5551231234',
                'dob'         => Carbon::createFromDate(1980, 12, 20),
                'fr_code'     => FrCodeGenerator::generate(),
            ]
        );

        $parentUser = User::find(4);

        $classroom = Classroom::first();
        Queue::fake();

        $registerModel = new RegisterModel();
        $registerModel->createParticipant($participantUser, $parentUser, $classroom, false, null);
        Queue::assertNotPushed(BindParticipantPrizes::class);
        $studentsPrizes     = PrizesBoundStudent::where('student_id', '=', $participantUser->id)->get()->count();
        $numClassroomPrizes = $classroom->group->prizesBound->count();
        $this->assertEquals($studentsPrizes, $numClassroomPrizes);

    }

    public function testNotificationFeatureFlagInRegistrationWhenEnabled()
    {
        Queue::fake();
        $this->mockNotificationFeatureFlag(true);

        $participantUser = factory(User::class)->create();

        $parentUser = User::find(4);
        $this->be($parentUser);
        $classroom = Classroom::first();

        $registerModel = new RegisterModel();
        $registerModel->createParticipant($participantUser, $parentUser, $classroom, false, null);

        Queue::assertPushed(AddUserNotifications::class);
    }

    public function testNotificationFeatureFlagInRegistrationWhenDisabled()
    {
        Queue::fake();
        $this->mockNotificationFeatureFlag(false);

        $participantUser = factory(User::class)->create();

        $parentUser = User::find(4);
        $this->be($parentUser);
        $classroom = Classroom::first();

        $registerModel = new RegisterModel();
        $registerModel->createParticipant($participantUser, $parentUser, $classroom, false, null);

        Queue::assertNotPushed(AddUserNotifications::class);
    }

    private function mockNotificationFeatureFlag($enabled)
    {
        FeatureFlag::shouldReceive('checkIfGloballyEnabled')
            ->with('notifications')
            ->andReturn($enabled);
    }
}
