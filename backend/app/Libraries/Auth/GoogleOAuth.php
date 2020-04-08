<?php

namespace App\Libraries\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Entities\SocialLogin;
use App\Models\RegisterModel;
use App\Entities\User;
use Predis\Command\KeyExists;
use GuzzleHttp\Client as Client;
use Log;

class GoogleOAuth implements OAuthInterface
{
    protected $provider = 'google';

    public function getUser()
    {
        $socialiteUser = Socialite::driver($this->provider)->redirectUrl(secure_url('/v3/oauth/google'))->user();

        //check for user in database
        $socialLogin = SocialLogin::where('google', $socialiteUser->id)->with('user')->first();
        if ($socialLogin) {
            return $socialLogin->user;
        }
        return $this->createUser($socialiteUser);
    }

    private function createUser($socialiteUser)
    {
        $user = User::where('email', $socialiteUser->email)->first();
        if (! $user) {
            $socialiteUser = $this->getUserMetaData($socialiteUser);
            $registerModel = new RegisterModel();
            $registerData  = $this->transformForRegisterParent($socialiteUser);
            $user          = $registerModel->registerParent($registerData);
        }
        $this->createSocialLogin($socialiteUser->id, $user);
        return $user;
    }

    private function createSocialLogin($socialId, $user)
    {
        $socialLogin   = new SocialLogin(['google'=>$socialId]);
        $user->socialLogin()->save($socialLogin);
    }

    private function transformForRegisterParent($socialiteUser)
    {
        $year  = null;
        $month = null;
        $day   = null;
        $phone = null;

        if (isset($socialiteUser->birthdate)) {
            $year  = $socialiteUser->birthdate->year;
            $month = $socialiteUser->birthdate->month;
            $day   = $socialiteUser->birthdate->day;
        }
        if (isset($socialiteUser->phone)) {
            $phone = $socialiteUser->phone;
        }
        return [
            'first_name'=> $socialiteUser->user['given_name'],
            'last_name' => $socialiteUser->user['family_name'],
            'year'      => $year, //birth year
            'month'     => $month, //birth month
            'day'       => $day, //birth day
            'email'     => $socialiteUser->email,
            'password'  => null,
            'phone'     => $phone,
        ];
    }

    /**
     * redirect to provider
     * persist callback state
     *
     * @param array $state data we want to persist to callback
     * @return void
     */
    public function getRedirect()
    {
        config(['services.google.redirect' => secure_url('/v3/oauth/google')]);

        return Socialite::driver($this->provider)
            ->scopes(
                [
                    'https://www.googleapis.com/auth/user.birthday.read',
                    'https://www.googleapis.com/auth/user.phonenumbers.read'
                ]
            )
            ->redirect();
    }

    /**
     * Retrieves user metadata for profile information
     *
     * @param SociliateUser User
     * @returns SocialiteUser with modified params
     */
    private function getUserMetaData($user)
    {
        try {
            $client = new Client();
            $apiUrl = 'https://people.googleapis.com/v1/people/' . $user->id
                . '?personFields=emailAddresses%2Cbirthdays%2CphoneNumbers&key=' . env('GOOGLE_API_KEY');
            $response = $client->request('get', $apiUrl);
            $data     = json_decode($response->getBody()->getContents());

            if (isset($data->birthdays)) {
                $user->birthdate = $data->birthdays[0]->date;
            }
            if (isset($data->phoneNumbers)) {
                $user->phone = $data->phoneNumbers[0]->value;
            }

            return $user;
        } catch (\Exception $e) {
            Log::debug($e);
            return $user;
        }
    }
}
