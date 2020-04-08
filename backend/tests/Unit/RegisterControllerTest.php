<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\RegisterController;
use App\Entities\User;
use Illuminate\Support\Facades\Queue;
use Lang;

class RegisterControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test for the validateProfileComplete method with a valid profile.
     *
     * @return void
     */
    public function testValidateProfileCompleteWithValidUserData()
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get('/v3/api/validate-profile-complete')
            ->assertStatus(200)
            ->assertJsonFragment(['valid'=> true]);
    }

    /**
     * A basic unit test for the validateProfileComplete method with an invalid profile.
     *
     * @return void
     */
    public function testValidateProfileCompleteWithInvalidUserData()
    {
        $user = factory(User::class)->make([
            'first_name' => ''
        ]);

        $this->actingAs($user)
            ->get('/v3/api/validate-profile-complete')
            ->assertStatus(200)
            ->assertJsonFragment(['valid'=> false]);
    }

    /**
     * A test for validating invalid teacher registration code.
     *
     * @return void
     */
    public function testValidateTeacherRegistrationCodeWithInvalidData()
    {
        $invalidRegistrationCode = '1234-5678';
        $registerController = new RegisterController();
        $response = $registerController->validateTeacherRegistrationCode($invalidRegistrationCode);
        $message = json_decode($response->content())->message;

        $this->assertSame($message, Lang::get('register.invalid_teacher_code'));
    }

    /**
     * A test for validating valid teacher registration code without max teachers reached.
     *
     * @return void
     */
    public function testValidateTeacherRegistrationCodeWithValidDataWithoutMaxTeachersReached()
    {
        Queue::fake();

        $parentUser = User::where('email', 'parent@example.com')->first();
        $classroom = $parentUser->participants[0]->classroom[0];
        $classroom->teacher_3_id = null;
        $classroom->save();

        $validRegistrationCode = $classroom->team_leader_code;

        $response = $this->actingAs($parentUser)
            ->get('/v3/api/registration/validate_teacher_code/' . $validRegistrationCode)
            ->assertStatus(200);

        $message = json_decode($response->content());
        $this->assertSame($message->success, true);
        $this->assertSame($message->user->first_name, $parentUser->first_name);
    }

    /**
     * A test for validating valid teacher registration code with max teachers reached.
     *
     * @return void
     */
    public function testValidateTeacherRegistrationCodeWithValidDataWithMaxTeachersReached()
    {
        $parentUser = User::where('email', 'parent@example.com')->first();
        $classroom = $parentUser->participants[0]->classroom[0];
        $classroom->teacher_id   = $parentUser->id;
        $classroom->teacher_2_id = $parentUser->id;
        $classroom->teacher_3_id = $parentUser->id;
        $classroom->save();

        $validRegistrationCode = $classroom->team_leader_code;

        $response = $this->actingAs($parentUser)
            ->get('/v3/api/registration/validate_teacher_code/' . $validRegistrationCode)
            ->assertStatus(200);

        $message = json_decode($response->content());
        $this->assertSame($message->success, false);
        $this->assertSame($message->message, Lang::get('register.max_teachers_reached'));
    }

    /**
     * A test for validating an email address for registering.
     *
     * @return void
     */
    public function testValidatingAnEmailAddressForRegistrationThatIsAlreadyTaken()
    {
        $user = User::first();

        $response = $this->actingAs($user)
            ->post('/v3/api/register/email-address', ['emailAddress' => $user->email])
            ->assertStatus(200);

        $message = json_decode($response->content());

        $this->assertSame($message->email_available, false);
    }

    /**
     * A test for validating an available email address for registering.
     *
     * @return void
     */
    public function testValidatingAnEmailAddressForRegistrationThatIsAvailable()
    {
        $user = User::first();

        $response = $this->actingAs($user)
            ->post('/v3/api/register/email-address', ['emailAddress' => 'availableTestEmailAddress@example.com'])
            ->assertStatus(200);

        $message = json_decode($response->content());

        $this->assertSame($message->email_available, true);
    }
}
