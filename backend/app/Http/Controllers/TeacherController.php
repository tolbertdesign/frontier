<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Response\View\Welcome;
use App\Helpers\RouteHelper;
use Illuminate\Support\Facades\Session;

class TeacherController extends Controller
{
    public function registerView(Request $request)
    {
        $previousUrl = str_replace(url('/'), '', url()->previous());

        if ($previousUrl === '/v3/register/teacher' ||
            $previousUrl === '' ||
            $previousUrl === '/' ||
            ! RouteHelper::isValidRoute($previousUrl)
        ) {
            // Fallback to home page if we some how just landed directly on this page
            $previousUrl = '/v3/home/dashboard';
        }
        Session::put('userType', 'Teacher');
        $welcomeView = new Welcome($request);
        return $welcomeView->make('welcome-teacher', $previousUrl);
    }
}
