<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test to get the password reset email view.
     *
     * @return void
     */
    public function testGettingResetPasswordEmailFormView()
    {
        $response = $this->get('/v3/password/reset');

        $response->assertStatus(200)
            ->assertViewIs('auth.passwords.email');
    }
}
