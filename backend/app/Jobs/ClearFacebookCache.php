<?php

namespace App\Jobs;

use App\Libraries\Facebook;
use App\Entities\User;
use App\Models\FamilyPledging;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ClearFacebookCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $participantUser;
    protected $tries = 2;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $participantUser)
    {
        $this->participantUser = $participantUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $familyPledging = new FamilyPledging();
        $participants = $familyPledging->participants($this->participantUser);

        foreach ($participants as $participant) {
            $participant->getSpecialUrlByFacebookReferrer();
            Facebook::executeOpenGraphScrape($participant->getSpecialUrlByFacebookReferrer());
            $participant->getSpecialUrlByFacebookVideoReferrer();
            Facebook::executeOpenGraphScrape($participant->getSpecialUrlByFacebookVideoReferrer());
        }
    }
}
