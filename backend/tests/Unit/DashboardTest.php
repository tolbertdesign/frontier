<?php

namespace Tests\Unit;

use App\Entities\AccessToken;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentStarVideoReadyEmail;
use App\Http\Controllers\DashboardController;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DashboardTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    private $parentUser;
    private $testRedirectValue;
    private $parentUserToken;
    private $participantUser;
    private $userWithEmailOptOut;
    private $emailToken;

    public function setUp() : void
    {
        parent::setUp();

        $this->parentUser          = User::where('email', 'parent@example.com')->first();
        $this->testRedirectValue   = 'testRedirectValue';
        $this->participantUser     = $this->parentUser->participants[0];
        $this->userWithEmailOptOut = User::where('email_opt_out', 0)->first();
        $this->emailToken          = Crypt::encryptString($this->userWithEmailOptOut->email);
        Mail::fake();
    }

    /**
     * A basic test for sending an email when student star video ready
     *
     * @return  void
     */
    public function testSendingStudentStarVideoReadyEmail()
    {
        $this->post('/v3/api/email/student-star-video-ready', ['id_participant' => $this->participantUser->id]);

        Mail::assertSent(StudentStarVideoReadyEmail::class, function ($mail) {
            $mail->build();
            return $mail->participantUser->id === $this->participantUser->id;
        });
    }

    /**
     * A basic test for loading dashboard without the parent_dashboard session variable
     *
     * @return  void
     *
     */
    public function testGettingDashboardAsUser()
    {
        $this->actingAs($this->parentUser)
            ->get('/v3/home/dashboard')
            ->assertStatus(302);
    }

    /**
     * A basic test for attempting to laod the dashboard without parent_dashboard_enabled
     *
     * @return  void
     *
     */
    public function testLoadingDashboardAsUserWithoutParentDashboardEnabled()
    {
        Config::set('booster.parent_dashboard_enabled', false);
        $this->actingAs($this->parentUser)
            ->withSession(['parent_dashboard' => true])
            ->get('/v3/home/dashboard')
            ->assertStatus(302);

        Config::set('booster.parent_dashboard_enabled', env('PARENT_DASHBOARD_ENABLED'));
    }

    /**
     * A basic test for loading dashboard while logged in with the parent_dashboard session
     *
     * @return  void
     *
     */
    public function testLoadingDashboardAsUser()
    {
        Config::set('booster.parent_dashboard_enabled', true);

        $this->actingAs($this->parentUser)
            ->withSession(['parent_dashboard' => true])
            ->get('/v3/home/dashboard')
            ->assertViewIs('dashboard');

        Config::set('booster.parent_dashboard_enabled', env('PARENT_DASHBOARD_ENABLED'));
    }

    /**
     * A basic test for loading dashboard when in beta
     *
     * @return  void
     *
     */
    public function testLoadingDashboardAsUserInBeta()
    {
        $this->actingAs($this->parentUser)
            ->withSession([
                'parent_dashboard' => true
            ])
            ->get('/v3/home/dashboard/beta')
            ->assertRedirect('/v3');
    }

    /**
     * A basic test for the beta killswitch.
     *
     * @return  void
     *
     */
    public function testForBetaRedirectKillswitch()
    {
        Config::set('booster.parent_dashboard_enabled', true);
        Config::set('booster.beta_redirect_kill_switch', true);
        $this->actingAs($this->parentUser)
            ->withSession(['parent_dashboard' => true])
            ->get('/v3/home/dashboard')
            ->assertStatus(302);

        Config::set('booster.parent_dashboard_enabled', env('PARENT_DASHBOARD_ENABLED'));
        Config::set('booster.beta_redirect_kill_switch', env('BETA_REDIRECT_KILL_SWITCH'));
    }

    /**
     * A basic test with mocking for the Parent Dashboard Enabled
     *
     * @return  void
     */
    public function testParentDashboardEnabled()
    {
        Config::set('booster.parent_dashboard_enabled', false);

        $dashboardControllerMock = $this->getMockBuilder(DashboardController::class)
            ->setMethods(['tkindex'])
            ->getMock();

        $dashboardControllerMock->expects($this->once())
            ->method('tkindex');

        $this->actingAs($this->parentUser);

        $request = Request::create('/v3/home/dashboard', 'GET');

        $dashboardControllerMock->dashboard($request);
    }

    /**
     * A basic test with mocking for the dashboard alpha session
     *
     * @return  void
     */
    public function testDashboardAlphaSessionCallsTkIndexFunction()
    {
        Cookie::queue(Cookie::make('parent_dashboard', 'true', null, '/', '.boosterthon.com'));

        $dashboardControllerMock = $this->getMockBuilder(DashboardController::class)
            ->setMethods(['tkindex'])
            ->getMock();

        $dashboardControllerMock->expects($this->once())
            ->method('tkindex');

        $this->actingAs($this->parentUser);

        $request = Request::create('/v3/home/dashboard', 'GET');

        $dashboardControllerMock->dashboard($request);
    }

    /**
     * A basic test for the Titan Signup Killswitch
     *
     * @group test
     * @return  void

    public function testTitanSignupKillswitch()
    {
        Config::set('booster.titan_signup_killswitch', true);

        $dashboardControllerMock = $this->getMockBuilder(DashboardController::class)
            ->setMethods(['classicSignUpRegistration'])
            ->getMock();

        $dashboardControllerMock->expects($this->once())
            ->method('classicSignUpRegistration');

        $this->actingAs($this->parentUser);

        $request = Request::create('/v3/home/dashboard', 'GET');
        $dashboardControllerMock->dashboard($request);
    }
    */

    /**
     * A basic test for the TK Index
     *
     * @return  void
     */
    public function testTkIndexWithRedirectValue()
    {
        $result = $this->actingAs($this->parentUser)
            ->get('/v3/tkdashboard/?redirect=' . $this->testRedirectValue)
            ->assertStatus(302);
        $token = AccessToken::where('user_id', $this->parentUser->id)
            ->orderBy('id', 'desc')->first();
        $result->assertRedirect(secure_url('/login-titan/' . $this->parentUser->id . '/' . $token->access_token));
    }

    /**
     * A basic test for the TK Index reroute
     *
     * @return  void
     */
    public function testTkIndexWithoutRedirectValue()
    {
        $result = $this->actingAs($this->parentUser)
            ->get('/v3/tkdashboard')
            ->assertStatus(302);
        $token = AccessToken::where('user_id', $this->parentUser->id)
            ->orderBy('id', 'desc')->first();
        $result->assertRedirect(secure_url('/login-titan/' . $this->parentUser->id . '/' . $token->access_token));
    }

    /**
     * A basic test for the TK Index with beta banner redirect route
     *
     * @return  void
     */
    public function testTkIndexWithBetaBannerRedirectValue()
    {
        $result = $this->actingAs($this->parentUser)
            ->get('/v3/tkdashboard/?redirect=home/dashboard?dashboardBetaOptOut=true')
            ->assertStatus(302)
            ->assertSessionHas('parent_dashboard', false);
        $token = AccessToken::where('user_id', $this->parentUser->id)
            ->orderBy('id', 'desc')->first();
        $result->assertRedirect(secure_url('/login-titan/' . $this->parentUser->id . '/' . $token->access_token));
    }

    /**
     * A basic test for TK Participant Registration
     *
     * @return  void
     */
    public function testTkRegisterParticipant()
    {
        $tkUrl = Config::get('booster.trapper_url') . '/auth/login/' . $this->parentUser->fr_code . '/register-participant/0';

        $this->actingAs($this->parentUser)
            ->get('/v3/tk-register-participant')
            ->assertStatus(302)
            ->assertRedirect($tkUrl);
    }

    /**
     * A basic test for the TK classic signup registration cookie
     *
     * @return  void

    public function testTitanClassicSignupCookie()
    {
        $this->actingAs($this->parentUser)
            ->get('/v3/classic-signup-registration')
            ->assertPlainCookie('use_new_signup_page', 'false');
    }
    */

    /**
     * A basic test for the TK classic signup registration in testing or local mode
     *
     * @return  void
     */
    public function testTitanClassicSignupWhileInTestingOrLocal()
    {
        Config::set('booster.app_env', 'testing');

        $this->actingAs($this->parentUser)
            ->get('/v3/classic-signup-registration')
            ->assertRedirect(Config::get('booster.trapper_url'));
    }

    /**
     * A basic test for the TK classic signup registration in production mode
     *
     * @return  void
     */
    public function testTitanClassicSignupWhileInProduction()
    {
        Config::set('booster.app_env', 'production');

        $this->actingAs($this->parentUser)
            ->get('/v3/classic-signup-registration')
            ->assertRedirect('/');
    }

    /**
     * A basic test for the dashboard email preferences
     *
     * @return  void
     */
    public function testDashboardEmailPreferences()
    {
        $this->actingAs($this->userWithEmailOptOut)
            ->get('/v3/email-preferences/' . $this->emailToken)
            ->assertViewIs('email-preferences');
    }

    /**
     * A basic test for updating dashboard email preferences
     *
     * @return  void
     */
    public function testDashboardUpdateEmailPreferences()
    {
        $this->assertEquals($this->userWithEmailOptOut->email_opt_out, 0);

        $this->actingAs($this->userWithEmailOptOut)
            ->post('/v3/update-email-preferences', [
                'emailToken' => $this->emailToken,
                'blockAll'   => 1,
            ])
            ->assertStatus(302);

        $reloadedUser = User::where('id', $this->userWithEmailOptOut->id)->first();

        $this->assertEquals($reloadedUser->email_opt_out, 1);
    }

    /**
     * A test for dashboardUser when authorized with parent dashboard enabled
     *
     * @return  void
     */
    public function testDashboardUserWhenLoggedInAsUserWithParentDashboardSession()
    {
        $result = $this->actingAs($this->parentUser)
            ->withSession([
                'parent_dashboard' => true
            ])
            ->get('/v3/home/dashboard-user');

        $response = $result->json();

        $this->assertSame($response['id'], $this->parentUser->id);
        $this->assertSame($response['first_name'], $this->parentUser->first_name);
        $this->assertSame($response['last_name'], $this->parentUser->last_name);
        $this->assertSame($response['email'], $this->parentUser->email);
    }

    /**
     * A test for dashboardUser when not logged in
     *
     * @return  void
     */
    public function testDashboardUserWhenNotLoggedInAsUser()
    {
        $this->get('/v3/home/dashboard-user')
            ->assertStatus(302)
            ->assertRedirect('/v3');
    }

    public function testDashboardFromTk()
    {
        $tokenObj = $this->parentUser->createAccessToken();
        $this->actingAs($this->parentUser)
            ->get('/v3/tk-pledge-complete/' . $this->parentUser->id . '/' . $tokenObj->access_token)
            ->assertStatus(302)
            ->assertSee('/v3/home/dashboard');
    }

    public function testDashboardFromTkInvalid()
    {
        $tokenObj = $this->parentUser->createAccessToken();
        $this->actingAs($this->parentUser)
            ->get('/v3/tk-pledge-complete/' . $this->parentUser->id . '/' . $tokenObj->access_token . 'making-token-invalid')
            ->assertStatus(302)
            ->assertSessionHasErrors(['message']);
    }

    public function testDashboardFromTkInvalidViaExpired()
    {
        $tokenObj             = $this->parentUser->createAccessToken();
        $tokenObj->expires_at = Carbon::now()->subWeek();
        $tokenObj->save();
        $this->actingAs($this->parentUser)
            ->get('/v3/tk-pledge-complete/' . $this->parentUser->id . '/' . $tokenObj->access_token)
            ->assertStatus(302)
            ->assertSessionHasErrors(['message']);
    }
}
