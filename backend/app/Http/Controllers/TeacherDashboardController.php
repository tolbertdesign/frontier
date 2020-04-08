<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\DashboardUser\TeacherUser;

class TeacherDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            'auth'
        );
    }

    public function dashboard(Request $request)
    {
        if ($this->shouldRedirectToTk()) {
            return $this->tkindex($request);
        }

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

        $user = (new TeacherUser(Auth::user()))->get();

        return $user;
    }
}
