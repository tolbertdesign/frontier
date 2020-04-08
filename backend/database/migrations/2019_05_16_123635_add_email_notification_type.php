<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\NotificationType;
use App\Entities\EventType;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\EventDispatcher\Event;

class AddEmailNotificationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $notificationType = new NotificationType();
        $notificationType->name = 'Email';
        $notificationType->class_name = 'EmailNotification';
        $notificationType->save();

        $eventType = new EventType();
        $eventType->name = 'Test';
        $eventType->notification_type_id = $notificationType->id;
        $eventType->notification_class_name = 'TestMail';
        $eventType->application = 'Mercury';
        $eventType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        NotificationType::where('name', 'Email')->delete();
        EventType::where('name', 'Test')->delete();
    }
}
