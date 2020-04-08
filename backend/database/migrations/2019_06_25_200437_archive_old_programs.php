<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArchiveOldPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "UPDATE programs
            SET archived = 1
            WHERE id IN(
                SELECT id FROM (
                    SELECT id
                    FROM programs
                    WHERE semester IN('2019-1-Spring', '2018-2-Fall')
                    and team_id not IN(13, 1002, 1019)
                ) AS programids
            )"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(
            "UPDATE programs
            SET archived = 0
            WHERE id IN(
                SELECT id FROM (
                    SELECT id
                    FROM programs
                    WHERE semester IN('2019-1-Spring', '2018-2-Fall')
                    and team_id not IN(13, 1002, 1019)
                ) AS programids
            )"
        );
    }
}
