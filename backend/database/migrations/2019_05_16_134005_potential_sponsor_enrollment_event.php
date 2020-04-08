<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\EventType;
use App\Entities\NotificationType;

class PotentialSponsorEnrollmentEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $eventType = new EventType();
        $eventType->name = 'PotentialSponsorEnrollment';
        $eventType->notification_type_id = NotificationType::where('name', 'Email')->first()->id;
        $eventType->notification_class_name = 'PotentialSponsorEnrollment';
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
        EventType::where('name', 'PotentialSponsorEnrollment')->where('application', 'Mercury')->delete();
    }
}
