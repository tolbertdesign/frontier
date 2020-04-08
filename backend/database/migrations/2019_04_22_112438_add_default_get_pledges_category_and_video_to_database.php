<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Video;

class AddDefaultGetPledgesCategoryAndVideoToDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //@codingStandardsIgnoreStart
        $videoCategoryId = DB::table('video_categories')-> insertGetId([
            'name' => 'how_to_get_pledges',
        ]);

        Video::where('title', 'Get Pledges Video')
            ->update(['video_category_id' => $videoCategoryId]);
        //@codingStandardsIgnoreEnd
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Video::where('title', 'Get Pledges Video')
            ->update(['video_category_id' => null]);

        DB::delete('delete from video_categories where name = \'how_to_get_pledges\'');
    }
}
