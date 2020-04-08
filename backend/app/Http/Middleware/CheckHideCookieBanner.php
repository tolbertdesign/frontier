<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class CheckHideCookieBanner
{
    public function handle($request, Closure $next)
    {
        $hideCookiePolicy = $request->cookie('hide_cookie_policy_v3') ? true : false;
        config(['privacy.hideCookiePolicy' => $hideCookiePolicy]);
        Cookie::queue(Cookie::make('hide_cookie_policy', 'hide', null, '/', '.boosterthon.com'));
        return $next($request);
    }
}
