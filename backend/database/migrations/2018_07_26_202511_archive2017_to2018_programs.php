<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Archive2017To2018Programs extends Migration
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
                    WHERE semester IN('2018-1-Spring', '2017-2-Fall')
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
            SET archived = NULL
            WHERE id IN(
                SELECT id FROM (
                    SELECT id
                    FROM programs
                    WHERE semester IN('2018-1-Spring', '2017-2-Fall')
                    and team_id not IN(13, 1002, 1019)
                ) AS programids
            )"
        );
    }
}
