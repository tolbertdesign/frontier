<?php

namespace App\Jobs;

use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BindParticipantPrizes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $retryAfter = 2;

    private $participantUser;

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
        $this->participantUser->bindNewParticipantPrizes();
    }
}
