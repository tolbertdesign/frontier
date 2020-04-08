<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;

class UserHasParticipantsOrPledges
{
    private $urls = [
        'v3/register/participant',
        'v3/api/registration/validate_teacher_code/*',
        'v3/tk-register-participant',
        'v3/classic-signup-registration',
        'v3/tkdashboard',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()
            && $this->hasNoActiveParticipant() // if they have participants let them through
            && $this->hasNoActivePledge()
            && ! $request->is($this->urls)) {
            return redirect()->action('Auth\AuthController@welcome');
        }

        return $next($request);
    }

    public function hasNoActiveParticipant()
    {
        return Auth::user()->participants()->count() == 0;
    }

    private function hasNoActivePledge()
    {
        return Auth::user()
            ->sponsorPledges()
            ->with('program')
            ->get()
            ->filter(function ($pledge) {
                return $pledge->program->archived == 0;
            })
            ->count() == 0;
    }
}
