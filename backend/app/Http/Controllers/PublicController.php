<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Program;
use App\Entities\SpecialUrl;
use App\Models\FamilyPledging;
use App\Models\SponsorLeaderboard;
use App\Models\WelcomeVideos;
use App\Models\BusinessLeaderboard;
use Cookie;
use Log;
use Exception;

class PublicController extends Controller
{
    public function index(Request $request, String $shortKey)
    {
        if (config('booster.TITAN_KILL_SWITCH')) {
            return redirect()->secure('/a/s/' . $shortKey);
        }

        $specialUrl = SpecialUrl::where('short_key', $shortKey)
            ->join('users', 'users.id', '=', 'special_urls.user_id')
            ->where('users.deleted_at', null)
            ->first();

        if (! $specialUrl || ! $specialUrl->user) {
            return response()->view('errors.invalid_pledge_page', [], 404);
        }

        if ($request->input('utm_source') == null) {
            try {
                $url      =  secure_url('/v3/dash/' . $shortKey) . $specialUrl->UTMLink();
                return redirect($url);
            } catch (Exception $e) {
                Log::warning('Unable to track campaigns for ' . $shortKey);
            }
        }

        $familyPledging          = new FamilyPledging();
        $participants            = $familyPledging->participants($specialUrl->user);
        $participantDisplayNames = FamilyPledging::displayNames($participants);
        $shareImage              = FamilyPledging::shareImage($participants);
        $program                 = $participants->first()->participantInfo->classroom->group->program;
        $sponsorLeaderboard      = new SponsorLeaderboard($participants);
        $businessLeaderboard     = new BusinessLeaderboard($program);
        $welcomeVideos           = new WelcomeVideos($participants);
        $hideCookiePolicy        = $request->cookie('hide_cookie_policy') ? true : false;
        Cookie::queue('ref_code', $specialUrl->slug, null, '/', '.boosterthon.com');

        $pageData = [
            'participants'            => $participants,
            'sponsorLeaderboard'      => $sponsorLeaderboard,
            'businessLeaderboard'     => $businessLeaderboard,
            'welcomeVideos'           => $welcomeVideos,
            'program'                 => $program,
            'refShortKey'             => $shortKey,
            'specialUrl'              => $specialUrl,
            'hideCookiePolicy'        => $hideCookiePolicy,
            'participantDisplayNames' => $participantDisplayNames,
            'shareImage'              => $shareImage,
        ];

        return view('public_dash', $pageData);
    }

    public function pledges($program_id)
    {
        $program = Program::findOrFail($program_id);
        $pledges = $program->pledges()->with('pledgeSponsor')->
        where('amount', '>', '75.00')->orderBy('amount', 'DESC')->paginate(20);
        return $pledges;
    }
}
