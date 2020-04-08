<?php

namespace App\Http\Response\View;

use Illuminate\Http\Request;

class Welcome
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function make($startingPosition = null, $loggedInBackAction = null)
    {
        $isBetaUser = false;
        $isOrgAdmin = false;

        if (session('parent_dashboard')) {
            $isBetaUser = true;
        }

        if (session('is_org_admin')) {
            $isOrgAdmin = true;
        }

        $bodyClass = strpos($this->request->root(), 'boosterbash') === false ? null : 'booster-bash-bg';
        $showSnow  = (in_array(date('M'), ['Jan', 'Dec'])) ? 'true' : 'false';

        $params = [
            'bodyClass'  => $bodyClass,
            'showSnow'   => $showSnow,
            'isBetaUser' => $isBetaUser,
            'isOrgAdmin' => $isOrgAdmin
        ];

        if ($loggedInBackAction) {
            $params['loggedInBackAction'] = $loggedInBackAction;
        }

        if ($startingPosition) {
            $params['startingPosition'] = $startingPosition;
        }

        return response()->view('auth.welcome', $params)->header(
            'Cache-Control',
            'private, max-age=0, no-cache, no-store'
        );
    }
}
