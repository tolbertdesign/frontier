<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Request;

class UserIsAdminOrOrgAdmin
{
    private $urls = [
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
        && Auth::user()->hasAnyRole(['admin', 'Organization Admin', 'System Administrator'])
        && ! $request->is($this->urls)) {
            return redirect()->action('DashboardController@tkindex');
        }

        return $next($request);
    }
}
