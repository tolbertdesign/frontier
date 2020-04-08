<?php

namespace App\Models;

class SponsorLeaderboard
{
    private $participants;

    public function __construct($participants)
    {
        $this->participants = $participants;
    }

    public function getPledges()
    {
        $program = $this->participants->first()->participantInfo->classroom->group->program;
        $pledges = $this->participants->reduce(function ($allPledges, $participant) {
            return $allPledges->merge($participant->participantPledges);
        }, collect([]))->sortByDesc(function ($pledge) use ($program) {
            return $pledge->flatAmount();
        });
        return $pledges;
    }
}
