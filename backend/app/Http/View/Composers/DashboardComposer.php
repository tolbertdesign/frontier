<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Cache;
use App\Entities\SponsorType;
use App\Entities\PledgeType;
use App\Entities\Country;
use App\Entities\State;

class DashboardComposer
{
    public function compose(View $view)
    {
        $sponsorTypes = Cache::rememberForever('sponsorTypes', function () {
            return SponsorType::all();
        });

        $pledgeTypes = Cache::rememberForever('pledgeTypes', function () {
            return PledgeType::all();
        });

        $countries = Cache::rememberForever('countries', function () {
            return Country::all();
        });

        $states = Cache::rememberForever('states', function () {
            return State::all();
        });

        $view->with('sponsorTypes', $sponsorTypes);
        $view->with('pledgeTypes', $pledgeTypes);
        $view->with('countries', $countries);
        $view->with('states', $states);
    }
}
