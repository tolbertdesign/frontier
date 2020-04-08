<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Video;

class AlterVideosSources extends Migration
{
    private $youtubeVideoIds = [
        'Uv-IZDxdZbM',
        '9yzeWoelJ3M',
    ];

    private $oldVimeoId = 'Boosterthon Overview';
    private $newVimeoId = '254873625';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update the sources for these videos to be youtube
        Video::whereIn('external_video_id', $this->youtubeVideoIds)
            ->where('source', 'vimeo')
            ->update([
                'source' => 'youtube'
            ]);

        // Update vimeo video so it has a usable video ID
        Video::where('external_video_id', $this->oldVimeoId)->update([
            'external_video_id' => $this->newVimeoId
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the sources for these videos to be vimeo
        Video::whereIn('external_video_id', $this->youtubeVideoIds)
            ->where('source', 'youtube')
            ->update([
                'source' => 'vimeo'
            ]);

        // Revert vimeo video to old video ID
        Video::where('external_video_id', $this->newVimeoId)->update([
            'external_video_id' => $this->oldVimeoId
        ]);
    }
}
