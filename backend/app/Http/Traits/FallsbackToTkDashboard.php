<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Auth;

trait FallsbackToTkDashboard
{
    public function shouldRedirectToTk()
    {
        return !Config::get('booster.parent_dashboard_enabled') || !session('parent_dashboard') || Config::get('booster.beta_redirect_kill_switch');
    }

    /**
     * Show the TK dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function tkindex(Request $request, $redirect = null)
    {
        if ($redirect === null && $request->input('redirect') !== null) {
            $redirect = $request->input('redirect');
        }

        // Check if beta banner was clicked
        if ($redirect === 'home/dashboard?dashboardBetaOptOut=true') {
            session(['parent_dashboard' => false]);
        }

        $user  = Auth::user();
        $token = $user->createAccessToken($redirect);
        $tkUrl = secure_url('/login-titan/' . $user->id . '/' . $token->access_token);
        Auth::logout();
        return redirect($tkUrl);
    }
}
