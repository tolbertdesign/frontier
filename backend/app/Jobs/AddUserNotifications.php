<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\Notification;
use App\Entities\CustomProgramAlert;
use Illuminate\Support\Str;
use stdClass;
use App\Libraries\CacheKeys;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class AddUserNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userId;
    private $programId;
    private $customProgramAlert;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, int $programId)
    {
        $this->userId               = $userId;
        $this->programId            = $programId;
        $this->customProgramAlert   = CustomProgramAlert::where([
            'program_id' => $this->programId
        ])->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Notification::create([
                'id'              => Str::uuid(),
                'type'            => Notification::TYPE_PROGRAM,
                'notifiable_type' => 'App\Entities\User',
                'notifiable_id'   => $this->userId,
                'data'            => $this->getData(),
                'program_id'      => $this->programId,
                'created_at'      => Carbon::now()->format('Y-m-d H:i:s'),
                'starts_at'       => $this->customProgramAlert->start->format('Y-m-d H:i:s'),
                'ends_at'         => $this->customProgramAlert->end->format('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        $cacheKey = CacheKeys::getUserNotificationKey($this->userId);
        Cache::forget($cacheKey);
    }

    /**
     * Get the data for the notification as a JSON object.
     *
     * @return  JSON
     */
    public function getData()
    {
        $obj          = new stdClass();
        $obj->content = $this->customProgramAlert->text;

        return json_encode($obj);
    }
}
