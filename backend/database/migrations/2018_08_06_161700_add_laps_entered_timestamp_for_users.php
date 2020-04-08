<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLapsEnteredTimestampForUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            UPDATE users
            SET
                ts_laps_entered = NOW(),
                laps_modified_ts = NOW()
            WHERE
                (ts_laps_entered IS null
            AND
                laps IS NOT null)
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //No down. Can't determine previously null timestamps.
    }
}
