<?php

use App\Entities\Video;
use App\Entities\VideoCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

class AlterCharacterVideoDefaults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $characterVideoCategory = VideoCategory::where('name', 'character_videos')->first();

        Video::where('external_video_id', '278943769')
            ->where('video_category_id', $characterVideoCategory->id)
            ->update([
                'video_category_id' => null
            ]);

        Cache::forget('characterVideos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $characterVideoCategory = VideoCategory::where('name', 'character_videos')->first();

        Video::where('external_video_id', '278943769')
            ->where('video_category_id', null)
            ->update([
                'video_category_id' => $characterVideoCategory->id
            ]);

        Cache::forget('characterVideos');
    }
}
