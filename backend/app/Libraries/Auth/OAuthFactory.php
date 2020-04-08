<?php

namespace App\Libraries\Auth;

class OAuthFactory
{
    protected $allowedProviders = ['google'];

    public function getOAuth($provider)
    {
        $this->validateProvider($provider);

        switch ($provider) {
            case 'google':
                return new GoogleOAuth();
                break;
            default:
                return null;
        }
    }

    private function validateProvider($provider)
    {
        $isNotAllowedProvider = ! in_array($provider, $this->allowedProviders);
        abort_if($isNotAllowedProvider, '404');
    }
}
