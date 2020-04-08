<?php

namespace App\Libraries\Auth;

interface OAuthInterface
{
    public function getUser();

    public function getRedirect();
}
