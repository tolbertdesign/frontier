<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\Notification;
use App\Entities\Program;
use Illuminate\Support\Facades\Cache;
use App\Libraries\CacheKeys;

class DeleteNotificationByProgram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $program;
    private $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Program $program, $type)
    {
        $this->type    = $type;
        $this->program = $program;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::where('program_id', $this->program->id)
            ->where('type', $this->type)
            ->delete();

        $userIds = $this->program->getProgramUserIdsFromCache();

        foreach ($userIds as $userId) {
            Cache::forget(CacheKeys::getUserNotificationKey($userId));
        }
    }
}
