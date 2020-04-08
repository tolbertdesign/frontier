<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Response\View\Welcome;

class AuthController extends Controller
{
    /**
     * Displays the welcome screen for login.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome(Request $request)
    {
        $welcomeView = new Welcome($request);
        return $welcomeView->make();
    }
}
