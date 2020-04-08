<?php

namespace Tests\Unit;

use App\Entities\User;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OAuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $parentUser;

    public function setUp() : void
    {
        parent::setUp();

        $this->parentUser = User::where('email', 'parent@example.com')->first();
    }

    /**
     * Test completing registration.
     *
     * @return void
     */
    public function testCompleteRegistration()
    {
        $year    = '1970';
        $month   = '12';
        $day     = '31';
        $user    = [
            'first_name'             => 'first',
            'last_name'              => 'last',
            'phone'                  => '1234567890',
            'year'                   => $year,
            'month'                  => $month,
            'day'                    => $day,
            'is_social_registration' => true
        ];
        $userDob = Carbon::createFromDate($year, $month, $day);

        $this->assertNotSame($this->parentUser->first_name, $user['first_name']);
        $this->assertNotSame($this->parentUser->last_name, $user['last_name']);
        $this->assertNotSame($this->parentUser->phone, $user['phone']);
        $this->assertNotEquals($this->parentUser->dob, $userDob, '', 5);

        $this->actingAs($this->parentUser)
            ->post('/v3/oath/completeRegistration', $user);

        $this->assertSame($this->parentUser->first_name, $user['first_name']);
        $this->assertSame($this->parentUser->last_name, $user['last_name']);
        $this->assertSame($this->parentUser->phone, $user['phone']);
        $this->assertEquals($this->parentUser->dob, $userDob, '', 5);
    }

    /**
     * A test for the redirect to provider method.
     *
     * @return  void
     */
    public function testRedirectToProvider()
    {
        $user     = User::first();
        $provider = 'google';

        $response = $this->actingAs($user)
            ->get('/v3/oauth/redirect/' . $provider . '/parent')
            ->assertStatus(302);

        $this->assertTrue(strpos($response->content(), $provider) >= 0);
    }

    /**
     * A test for the redirect to provider method.
     *
     * @return  void
     */
    public function testRedirectToProviderWithInvalidProvider()
    {
        $user     = User::first();
        $provider = 'invalidProvider';

        $response = $this->actingAs($user)
            ->get('/v3/oauth/redirect/' . $provider . '/parent')
            ->assertStatus(404);

        $this->assertFalse(strpos($response->content(), $provider));
    }

    /**
     * A test for the getRedirectRoute method.
     *
     * @return  void
     */
    public function testGetRedirectRouteMethod()
    {
        $user     = User::first();
        $provider = 'invalidProvider';

        $response = $this->actingAs($user)
            ->get('/v3/oauth/redirect/' . $provider . '/parent')
            ->assertStatus(404);

        $this->assertFalse(strpos($response->content(), $provider));
    }

    /**
     * A test for the redirectFromProvider method with valid provider.
     *
     * @return  void
     */
    public function testRedirectFromProviderWithValidProviderButWithoutValidSocialUserInformation()
    {
        $user     = User::first();
        $provider = 'google';

        $this->actingAs($user)
            ->get('/v3/oauth/' . $provider)
            ->assertStatus(302)
            ->assertRedirect('/v3/tkdashboard');
    }

    /**
     * A test for the redirectFromProvider method with invalid provider.
     *
     * @return  void
     */
    public function testRedirectFromProviderWithInvalidProvider()
    {
        $user     = User::first();
        $provider = 'invalidProvider';

        $this->actingAs($user)
            ->get('/v3/oauth/' . $provider)
            ->assertStatus(302)
            ->assertRedirect('/v3/tkdashboard');
    }
}
