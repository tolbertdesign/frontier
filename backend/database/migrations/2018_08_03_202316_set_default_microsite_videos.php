<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetDefaultMicrositeVideos extends Migration
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
                microsites.video_3 = 546,
                microsites.video_5 = 547
            WHERE
                programs.fun_run > "2018-7-27"
                    AND (microsites.video_1 = ""
                    AND microsites.video_2 = ""
                    AND microsites.video_3 IS NULL
                    AND microsites.video_4 IS NULL
                    AND microsites.video_5 IS NULL)
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //No down. Can't determine if original videos were '', '', null, null, null
    }
}
