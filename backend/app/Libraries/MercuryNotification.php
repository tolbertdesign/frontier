<?php

namespace App\Libraries;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Entities\EventType;
use App\Entities\User;
use App\NotificationBuilder;
use Cache;

class MercuryNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $event;
    protected $users = [];

    public $tries   = 1;
    public $timeout = 30;
    public $application;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $event)
    {
        $this->data        = $data;
        $this->event       = $event;
        $this->application = config('app.name');
        $this->onConnection('mercury');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $event = $this->event;
        $application = $this->application;
        $eventType = Cache::remember($application . '.' . $event, 600, function () use ($event, $application) {
            return EventType::where('name', $event)->where('application', $application)->first();
        });
        $notification = Cache::remember($eventType->notificationType->class_name, 600, function () use ($eventType) {
            return NotificationBuilder::getNotification($eventType->notificationType->class_name);
        });
        $notification->loadNotification($this->data, $this->users);
        $notification->send($eventType->notification_class_name);
    }

    public function addRecipient(User $user)
    {
        array_push($this->users, $user);
    }

    public function addRecipients(array $users)
    {
        $this->users = array_merge($this->users, $users);
    }

    public function setRecipients(array $users)
    {
        $this->users = $users;
    }

    public function getRecipients()
    {
        return $this->users;
    }
}
