<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

class FinishLineEligible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (strpos($request->path(), 'home/finish-line')) {
            $finishLineEligible = false;
            $user               = Auth::user();
            foreach ($user->participants as $participant) {
                $program = $participant->participantInfo->classroom->group->program;
                $isActiveProgram = $program->archived === 0 && $program->deleted === 0;
                $hasFinishLine = $program->fun_run < Carbon::tomorrow() && $participant->laps !== null;
                if ($isActiveProgram && $hasFinishLine) {
                    $finishLineEligible = true;
                    break;
                }
            }

            if (!$finishLineEligible) {
                return redirect('/v3/home/dashboard');
            }
        }

        return $next($request);
    }
}
