<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Video;

class AlterDefaultIntroVideoUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Video::where('external_video_id', '278943779')
            ->update(['external_video_id' => 347646205]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Video::where('external_video_id', '347646205')
            ->update(['external_video_id' => 278943779]);
    }
}
