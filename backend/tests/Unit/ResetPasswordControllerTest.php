<?php

namespace Tests\Unit;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test to try and reset the password without being logged in.
     *
     * @return void
     */
    public function testResettingPasswordWhileLoggedOut()
    {
        $response = $this->post('/v3/password/reset', [
            'email'    => 'parent@example.com',
            'password' => 'secret'
        ]);

        $response->assertStatus(302)
            ->assertRedirect('');
    }

    /**
     * A test to try and reset the password while logged in.
     *
     * @return void
     */
    public function testResettingPasswordWhileLoggedIn()
    {
        $parent = User::where('email', 'parent@example.com')->first();

        $response = $this->actingAs($parent)
            ->post('/v3/password/reset', [
                'email'    => 'parent@example.com',
                'password' => 'secret'
            ]);

        $response->assertStatus(302)
            ->assertRedirect('/v3/home/dashboard');
    }
}
