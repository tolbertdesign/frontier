<?php

namespace Tests\Unit;

use App\Http\Controllers\Auth\OAuthController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    /**
     * A test to get the welcome page.
     *
     * @return void
     */
    public function testGettingWelcomeView()
    {
        $response = $this->get('/v3');

        $response->assertStatus(200)
            ->assertViewIs('auth.welcome');
    }

    /**
     * A test to ensure the getRedirectRoute method returns a redirect.
     *
     * @return void
     */
    public function testGetRedirectRouteWithoutBeingLoggedIn()
    {
        $oAuthController = new OAuthController();
        $result          = $oAuthController->getRedirectRoute();
        $this->assertObjectHasAttribute('targetUrl', $result);
    }
}
