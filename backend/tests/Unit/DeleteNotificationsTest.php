<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use App\Libraries\CacheKeys;
use App\Entities\User;
use App\Entities\Program;
use App\Entities\CustomProgramAlert;
use App\Entities\Notification;
use App\Jobs\DeleteNotificationByProgram;

class DeleteNotificationsTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        $this->user    = factory(User::class)->states('parent')->create();
        $this->program = $this->user->participants[0]->getProgram();

        factory(Notification::class)->create([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM
        ]);

        $dashboardUserIdsKey = CacheKeys::getDashboardUserIdsByProgramId($this->program->id);

        Cache::shouldReceive('get')
            ->with($dashboardUserIdsKey)
            ->andReturn([$this->user->id]);

        Cache::shouldReceive('forget')
            ->with(CacheKeys::getUserNotificationKey($this->user->id));

        Cache::shouldReceive('rememberForever')
            ->with($dashboardUserIdsKey, \Closure::class)
            ->andReturn([$this->user->id]);
    }

    /**
     *
     * @return void
     */
    public function testUserCacheGetsCleared()
    {
        $job = new DeleteNotificationByProgram($this->program, Notification::TYPE_PROGRAM);
        $job->handle();
    }

    /**
     *
     * @return void
     */
    public function testNotificationIsDeleted()
    {
        $job = new DeleteNotificationByProgram($this->program, Notification::TYPE_PROGRAM);
        $job->handle();

        $notificationObj = Notification::where([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM
        ])->first();

        $this->assertTrue(is_object($notificationObj) === false);
    }
}
