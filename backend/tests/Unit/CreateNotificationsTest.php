<?php

namespace Tests\Unit;

use App\Entities\Classroom;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use App\Libraries\CacheKeys;
use App\Entities\User;
use App\Entities\Program;
use App\Entities\CustomProgramAlert;
use App\Entities\Group;
use App\Entities\Notification;
use App\Entities\Participant;
use App\Jobs\CreateNotificationsByProgram;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use stdClass;

class CreateNotificationsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp() : void
    {
        parent::setUp();

        $this->user = factory(User::class)->states('parent')->create();
        $this->program = $this->user->participants[0]->getProgram();

        $this->customProgramAlert = factory(CustomProgramAlert::class)->create([
            'program_id' => $this->program->id
        ]);

        $dashboardUserIdsKey = CacheKeys::getDashboardUserIdsByProgramId($this->program->id);

        Cache::shouldReceive('get')
            ->with($dashboardUserIdsKey)
            ->andReturn([$this->user->id]);

        Cache::shouldReceive('rememberForever')
            ->with($dashboardUserIdsKey, \Closure::class)
            ->andReturn([$this->user->id]);

        Cache::shouldReceive('forget')
            ->with(CacheKeys::getUserNotificationKey($this->user->id));
    }

    /**
     *
     * @return void
     */
    public function testUserCacheGetsCleared()
    {
        $job = new CreateNotificationsByProgram($this->program);
        $job->handle();
    }

    /**
     *
     * @return void
     */
    public function testNotificationIsInserted()
    {
        $job = new CreateNotificationsByProgram($this->program);
        $job->handle();

        $notificationObj = Notification::where([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM
        ])->first();

        $this->assertTrue(is_object($notificationObj) === true);
        $this->assertTrue($notificationObj->notifiable_id === $this->user->id);
    }



    /**
     * We expect this exception because we are creating th enotification twice, when the key constraint is unique.
     *
     * @expectedException \Illuminate\Database\QueryException
     * @return void
     */
    public function testUniqueKeyConstraint()
    {
        factory(Notification::class, 2)->create([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM
        ]);
    }

    /**
     *
     * @return void
     */
    public function testNotificationIsNotInsertedTwice()
    {
        factory(Notification::class)->create([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM
        ]);

        $job = new CreateNotificationsByProgram($this->program);
        $job->handle();

        $notificationObjs = Notification::where([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM
        ]);

        $this->assertTrue($notificationObjs->count() === 1);
    }

    /**
     *
     * @return void
     */
    public function testExistingNotificationGetsUpdated()
    {
        $data  = new stdClass();
        $data->content = $this->customProgramAlert->text;

        factory(Notification::class)->create([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM,
            'data'          => json_encode($data)
        ]);

        $job = new CreateNotificationsByProgram($this->program);
        $job->handle();

        $notificationObj = Notification::where([
            'notifiable_id' => $this->user->id,
            'program_id'    => $this->program->id,
            'type'          => Notification::TYPE_PROGRAM
        ])->first();

        $this->assertTrue($notificationObj->data->content === $this->customProgramAlert->text);
    }
}
