<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use App\Entities\User;
use Illuminate\Support\Str;

class Zendesk
{
    private $user;
    private $zendeskKey;
    private $jwtToken;
    private $subdomain;

    /**
     * Instantiates an instance of the Zendesk Library
     *
     * @param App\Entities\User $user
     */
    public function __construct(User $user = null)
    {
        $this->subdomain = config('services.zendesk.subdomain');
        if (isset($user)) {
            $this->user       = $user;
            $this->zendeskKey = config('services.zendesk.key');
            $this->buildJWTToken();
        }
    }

    /**
     * Builds the token used to create JWT Tokens
     *
     * @return Array
     */
    private function buildToken()
    {
        $now       = time();
        return [
            'jti'          => md5(Str::random()),
            'iat'          => $now,
            'name'         => $this->user->first_name . ' ' . $this->user->last_name,
            'phone'        => $this->user->phone,
            'email'        => $this->user->email,
            'external_id'  => $this->user->id,
            'organization' => $this->user->getSchoolsForZendesk(),
            'tags'         => $this->user->getUserTypes()
        ];
    }

    /**
     * Makes the JWT token to be passed to ZD
     */
    private function buildJWTToken()
    {
        $token          = $this->buildToken();
        $this->jwtToken = JWT::encode($token, $this->zendeskKey);
    }

    /**
     * Generates the redirect url for Zendesk
     *
     * @return String url
     */
    public function redirectLocation()
    {
        if (isset($this->jwtToken)) {
            $location = 'https://' . $this->subdomain . '.zendesk.com/access/jwt?jwt=' . $this->jwtToken;
        } else {
            $location = 'https://' . $this->subdomain . '.zendesk.com';
        }
        return $location;
    }
}
