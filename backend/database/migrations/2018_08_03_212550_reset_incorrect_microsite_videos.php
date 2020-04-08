<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResetIncorrectMicrositeVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            UPDATE microsites
                    LEFT JOIN
                programs ON microsites.program_id = programs.id
            SET
                microsites.video_3 = NULL,
                microsites.video_5 = NULL
            WHERE
                programs.fun_run > "2018-7-27"
                    AND (microsites.video_1 = ""
                    AND microsites.video_2 = ""
                    AND microsites.video_3 = 546
                    AND microsites.video_4 IS NULL
                    AND microsites.video_5 = 547)
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('microsites', function (Blueprint $table) {
            //
        });
    }
}
