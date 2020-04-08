<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test to get the login page.
     *
     * @return void
     */
    public function testGettingLoginView()
    {
        $response = $this->get('/v3/login');

        $response->assertStatus(200)
            ->assertViewIs('auth.login');
    }

    /**
     * A test for the correct redirect when going to the login page while already logged in.
     *
     * @return void
     */
    public function testGettingLoginViewWhenAlreadyLoggedIn()
    {
        $user  = User::first();

        $response = $this->actingAs($user)
            ->get('/v3/login');

        $response->assertStatus(302)
            ->assertRedirect('/v3/home/dashboard');
    }
}
