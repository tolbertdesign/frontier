<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SyncUsersDeletedColumnsFromJan2018 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            'UPDATE users
            SET
                deleted_at = FROM_UNIXTIME(1514764800)
            WHERE
                deleted = 1 AND deleted_at IS NULL
            AND id > 11759630'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //This migration has no down.
    }
}
