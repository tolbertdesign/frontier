<?php

namespace Tests\Unit;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A valid test to change a user's password.
     *
     * @return void
     */
    public function testPasswordChangeRequestWithValidData()
    {
        $currentPassword = 'secret';
        $newPassword     = 'newSecret1!';
        $parentUser      = User::where('email', 'parent@example.com')->first();
        $data            = [
            'current'               => $currentPassword,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ];
        $this->actingAs($parentUser)
            ->post('/v3/password/change', $data)
            ->assertStatus(200);

        $refreshParentUser = User::find($parentUser->id);
        $this->assertTrue(Hash::check($newPassword, $refreshParentUser->password));
    }

    /**
     * An invalid test to change a user's password with incorrect password.
     *
     * @return void
     */
    public function testPasswordChangeRequestWithWrongPassword()
    {
        $currentPassword = 'wrong';
        $newPassword     = 'newSecret1!';
        $parentUser      = User::where('email', 'parent@example.com')->first();
        $data            = [
            'current'               => $currentPassword,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ];
        $this->actingAs($parentUser)
            ->post('/v3/password/change', $data)
            ->assertStatus(422);

        $refreshParentUser = User::find($parentUser->id);
        $this->assertFalse(Hash::check($newPassword, $refreshParentUser->password));
    }

    /**
     * An invalid test to change a user's password.
     *
     * @return void
     */
    public function testPasswordChangeRequestWithInvalidData()
    {
        $currentPassword = 'secret';
        $newPassword     = 'password'; // Does not meet criteria such as having numbers, special characters, etc.
        $parentUser      = User::where('email', 'parent@example.com')->first();
        $data            = [
            'current'               => $currentPassword,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ];
        $this->actingAs($parentUser)
            ->post('/v3/password/change', $data)
            ->assertStatus(302);

        $refreshParentUser = User::find($parentUser->id);
        $this->assertFalse(Hash::check($newPassword, $refreshParentUser->password));
    }

    /**
     * An invalid test to change a user's password.
     *
     * @return void
     */
    public function testPasswordChangeRequestWithPasswordsThatDoNotMatch()
    {
        $currentPassword = 'secret';
        $newPassword1     = 'badPassword1';
        $newPassword2     = 'badPassword2';
        $parentUser      = User::where('email', 'parent@example.com')->first();
        $data            = [
            'current'               => $currentPassword,
            'password'              => $newPassword1,
            'password_confirmation' => $newPassword2,
        ];
        $this->actingAs($parentUser)
            ->post('/v3/password/change', $data)
            ->assertStatus(302);

        $refreshParentUser = User::find($parentUser->id);
        $this->assertFalse(Hash::check($newPassword1, $refreshParentUser->password));
        $this->assertFalse(Hash::check($newPassword2, $refreshParentUser->password));
    }
}
