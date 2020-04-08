<?php

namespace App\Http\Controllers;

use App\Entities\AccessToken;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Crypt;
use App\Entities\UserEmailOptOut;
use App\Entities\User;
use App\Models\DashboardUser\ParentUser;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(
            'auth',
            [
                'except' => [
                    'classicSignUpRegistration',
                    'emailPreferences',
                    'updateEmailPreferences',
                    'dashboardBeta',
                    'tkAfterPledge',
                ]
            ]
        );
    }

    /**
     * Consume Trapperkeeper redirect after pledging.
     *
     * @return \Illuminate\Http\Response
     */
    public function tkAfterPledge(Request $request, int $userId, string $accessToken)
    {
        $tokenObj = AccessToken::getValidatedToken($userId, $accessToken);
        if (!is_object($tokenObj)) {
            // If not valid, logout & redirect to login page with an error message.
            return redirect(secure_url('/v3/login'))->withErrors(['message' => __('auth.access_token_invalid')]);
        }

        // If valid, log the user in manually & then redirect them to the DB value
        Auth::loginUsingId($userId, true);
        AccessToken::destroy($tokenObj->id);
        session(['parent_dashboard' => true]);
        return redirect(secure_url('/v3/home/dashboard'));
    }

    public function dashboardBeta()
    {
        session(['parent_dashboard' => true]);
        return redirect()->action('Auth\AuthController@welcome');
    }

    public function dashboard(Request $request)
    {
        // if ($this->shouldRedirectToTk()) {
        //     return $this->tkindex($request);
        // }

        $user = $this->dashboardUser($request);

        if (!$user->hasParticipants()) {
            return redirect('/v3');
        }

        return view('dashboard', compact('user'));
    }

    public function dashboardUser(Request $request)
    {
        if (!Auth::check()) {
            session(['parent_dashboard' => true]);
            return redirect()->action('Auth\AuthController@welcome');
        }

        $user = (new ParentUser(Auth::user()))->get();

        return $user;
    }

    /**
     * Show Trapperkeeper Register Participant.
     *
     * @return \Illuminate\Http\Response
     */
    public function tkRegisterParticipant()
    {
        $tkUrl = Config::get('booster.trapper_url') . '/auth/login/' . Auth::user()->fr_code . '/register-participant/0';
        Auth::logout();
        return redirect($tkUrl);
    }

    public function classicSignUpRegistration()
    {
        Cookie::queue(Cookie::make('use_new_signup_page', 'false', null, '/', '.boosterthon.com'));

        if (Config::get('booster.app_env') == 'testing' || Config::get('booster.app_env') == 'local') {
            return redirect(Config::get('booster.trapper_url'));
        }

        return redirect(secure_url('/'));
    }

    public function emailPreferences($emailToken)
    {
        $email       = Crypt::decryptString($emailToken);
        $user        = User::where('email', $email)->firstOrFail();
        $userOptOuts = UserEmailOptOut::where('email', $email)->get();

        return view(
            'email-preferences',
            [
                'emailToken'  => $emailToken,
                'user'        => $user,
                'userOptOuts' => $userOptOuts,
            ]
        );
    }

    public function updateEmailPreferences(Request $request)
    {
        $email = Crypt::decryptString($request->input('emailToken'));
        $user  = User::where('email', $email)->firstOrFail();

        $emailOptOut         = $request->input('blockAll');
        $user->email_opt_out = ($emailOptOut) ?: 0;
        $user->update();

        $emailTypeIdsToBlock = $request->input('emailTypeIdsToBlock');
        $user->updateEmailPreferences($emailTypeIdsToBlock);

        return redirect()->action(
            'DashboardController@emailPreferences',
            [
                'emailToken' => $request->input('emailToken'),
            ]
        )->with('status', Lang::get('email_preferences.preferences_updated'));
    }
}
