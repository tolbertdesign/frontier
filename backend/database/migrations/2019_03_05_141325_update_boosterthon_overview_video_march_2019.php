<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBoosterthonOverviewVideoMarch2019 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('microsite_videos')
            ->where('id', '546')
            ->update([
                'hash'         => '254873625',
                'original_url' => 'https://vimeo.com/254873625',
                'source'       => 'vimeo',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('microsite_videos')
            ->where('id', '546')
            ->update([
                'hash'         => 'Uv-IZDxdZbM',
                'original_url' => 'https://www.youtube.com/watch?v=Uv-IZDxdZbM',
                'source'       => 'youtube',
            ]);
    }
}
