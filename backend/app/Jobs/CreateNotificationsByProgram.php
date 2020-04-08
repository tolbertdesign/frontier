<?php

namespace App\Jobs;

use App\Entities\CustomProgramAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\Notification;
use App\Entities\Program;
use App\Libraries\CacheKeys;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;
use stdClass;
use Illuminate\Support\Facades\Log;

class CreateNotificationsByProgram implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $program;
    private $chunkSize = 1000;
    private $cacheKeyForProgramUsers;
    private $customProgramAlert;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Program $program)
    {
        $this->program = $program;
        $this->cacheKeyForProgramUsers = CacheKeys::getDashboardUserIdsByProgramId($this->program->id);
        $this->customProgramAlert      = CustomProgramAlert::where([
            'program_id' => $this->program->id
        ])->first();
    }

    protected function getData()
    {
        $obj          = new stdClass();
        $obj->content = $this->customProgramAlert->text;

        return json_encode($obj);
    }

    protected function getType()
    {
        return Notification::TYPE_PROGRAM;
    }

    protected function getStartsAt()
    {
        return $this->customProgramAlert->start;
    }

    protected function getEndsAt()
    {
        return $this->customProgramAlert->end;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->customProgramAlert) {
            return;
        }

        $userIds = $this->program->getProgramUserIdsFromCache();

        if (empty($userIds)) {
            return;
        }

        $userIdChunks = collect($userIds)->chunk($this->chunkSize);

        // Get current notifications
        $currentNotifiableIds = $this->getCurrentNotificationNotifiableIds();

        // Insert new records
        foreach ($userIdChunks as $chunkUserIds) {
            $newAlerts = [];

            foreach ($chunkUserIds as $userId) {
                if (! in_array($userId, $currentNotifiableIds)) {
                    $newAlerts[] = [
                        'id'                => Str::uuid(),
                        'type'              => $this->getType(),
                        'notifiable_type'   => 'App\Entities\User',
                        'notifiable_id'     => $userId,
                        'data'              => $this->getData(),
                        'program_id'        => $this->program->id,
                        'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                        'starts_at'         => $this->getStartsAt()->format('Y-m-d H:i:s'),
                        'ends_at'           => $this->getEndsAt()->format('Y-m-d H:i:s')
                    ];

                    // Clear program cache for the user
                    Cache::forget(CacheKeys::getUserNotificationKey($userId));
                }
            }

            if (!empty($newAlerts)) {
                // Add new notifications
                Notification::insert($newAlerts);

                Notification::where('program_id', $this->program->id)
                    ->whereIn('notifiable_id', $chunkUserIds)
                    ->update(
                        [
                            'data'      => $this->getData(),
                            'starts_at' => $this->getStartsAt(),
                            'ends_at'   => $this->getEndsAt()
                        ]
                    );
            }
        }
    }

    /**
     * Get current notification notifiable_ids for the program.
     *
     * @return  Array
     */
    public function getCurrentNotificationNotifiableIds()
    {
        return Notification::select('notifiable_id')
            ->where('program_id', $this->program->id)
            ->where('type', $this->getType())
            ->get()
            ->pluck('notifiable_id')
            ->toArray();
    }
}
