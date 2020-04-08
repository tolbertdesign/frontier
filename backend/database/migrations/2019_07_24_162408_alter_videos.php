<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Video;

class AlterVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Video::where('external_video_id', '347646205')->update([
            'external_video_id'   => 349877897,
            'title'               => 'Intro Video',
            'description'         => 'Intro Video',
            ]);
        Video::where('external_video_id', '278943907')->update([
            'external_video_id'   => 349877926,
            'title'               => 'Honesty vs Dishonesty',
            'description'         => 'Honesty vs Dishonesty',
        ]);
        Video::where('external_video_id', '278943914')->update([
            'external_video_id'   => 349877983,
            'title'               => 'Gratitude vs Ingratitude',
            'description'         => 'Gratitude vs Ingratitude',
        ]);
        Video::where('external_video_id', '278943920')->update([
            'external_video_id'   => 349878038,
            'title'               => 'Generosity vs Selfishness',
            'description'         => 'Generosity vs Selfishness',
        ]);
        Video::where('external_video_id', '278943926')->update([
            'external_video_id'   => 349878100,
            'title'               => 'Kindness vs Bullying',
            'description'         => 'Kindness vs Bullying',
        ]);
        Video::where('external_video_id', '278943935')->update([
            'external_video_id'   => 349878161,
            'title'               => 'Humility vs Arrogance',
            'description'         => 'Humility vs Arrogance',
        ]);
        Video::where('external_video_id', '278943944')->update([
            'external_video_id'   => 349878221,
            'title'               => 'Resolution',
            'description'         => 'Resolution',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Video::where('external_video_id', '349877897')->update([
            'external_video_id'   => 347646205,
            'title'               => 'Intro Video',
            'description'         => 'Intro Video',
        ]);
        Video::where('external_video_id', '349877926')->update([
            'external_video_id'   => 278943907,
            'title'               => 'Day 1: Citizenship',
            'description'         => 'Day 1: Citizenship',
        ]);
        Video::where('external_video_id', '349877983')->update([
            'external_video_id'   => 278943914,
            'title'               => 'Day 2: Zest',
            'description'         => 'Day 2: Zest',
        ]);
        Video::where('external_video_id', '349878038')->update([
            'external_video_id'   => 278943920,
            'title'               => 'Day 3: Growth Mindset',
            'description'         => 'Day 3: Growth Mindset',
        ]);
        Video::where('external_video_id', '349878100')->update([
            'external_video_id'   => 278943926,
            'title'               => 'Day 4: Integrity',
            'description'         => 'Day 4: Integrity',
        ]);
        Video::where('external_video_id', '349878161')->update([
            'external_video_id'   => 278943935,
            'title'               => 'Day 5: Teamwork',
            'description'         => 'Day 5: Teamwork',
        ]);
        Video::where('external_video_id', '349878221')->update([
            'external_video_id'   => 278943944,
            'title'               => 'Day 6: Resolution',
            'description'         => 'Day 6: Resolution',
        ]);
    }
}
