<?php

namespace App\Http\Controllers;

use Auth;
use App\Libraries\Zendesk;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function redirectToZenDesk(Request $request)
    {
        $returnTo = $request->input('return_to');
        if (! Auth::check() && isset($returnTo)) {
            return redirect()->action('SupportController@zendeskLogin');
        }
        if (Auth::check()) {
            $zendesk = new Zendesk(Auth::user());
        } else {
            $zendesk = new Zendesk();
        }
        $location      = $zendesk->redirectLocation();

        //Redirect if this came from zendesk
        if (isset($returnTo)) {
            $location .= '&return_to=' . urlencode($returnTo);
        }
        // Redirect
        return redirect($location);
    }

    public function zendeskLogin(Request $request)
    {
        return $this->redirectToZenDesk($request);
    }
}
