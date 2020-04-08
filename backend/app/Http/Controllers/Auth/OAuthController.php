<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Session;
use Log;
use \Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Auth\OAuthFactory;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\UserRegistrationRequest;
use Laravel\Socialite\Two\InvalidStateException;

class OAuthController extends Controller
{
    protected $oAuthFactory;

    public function __construct()
    {
        $this->oAuthFactory = new OAuthFactory();
    }

    public function completeRegistration(UserRegistrationRequest $request)
    {
        $user             = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->phone      = $request->phone;
        $user->dob        = Carbon::createFromDate($request->year, $request->month, $request->day);
        $user->save();
        return $user;
    }

    public function redirectToProvider(String $provider, String $userType = null)
    {
        $oAuth = $this->oAuthFactory->getOAuth($provider);
        if ($userType) {
            Session::put('userType', $userType);
        }
        return $oAuth->getRedirect();
    }

    public function redirectFromProvider(Request $request, String $provider)
    {
        try {
            $oAuth = $this->oAuthFactory->getOAuth($provider);
            $user  = $oAuth->getUser();
            Auth::login($user, true);

            /**
             * Certain exception we don't care about
             * for example the user clicking back on a just used token,
             * the user declining permissions (error 400 on ClientException).
             * Others we will log so we can find out if there are problems or other scenarios
             * we did not account for
             */
        } catch (InvalidStateException $e) {
            //don't log
        } catch (ClientException $e) {
            if ($e->getCode() !== 400) {
                Log::warning($e->getMessage());
            }
        } catch (Exception $e) {
            Log::warning($e->getMessage());
        }
        return $this->getRedirectRoute();
    }

    /**
     * Return the route that the user should be sent to after handling
     * attempted oauth (successful or failed)
     *
     * @return Redirect Redirect object that determines where user is sent
     */
    public function getRedirectRoute()
    {
        if (Auth::user()) {
            return redirect('/v3/tkdashboard');
        }
        return redirect('/v3/');
    }
}
