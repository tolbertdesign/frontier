<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeVideosTableForTitan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('videos');
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('external_video_id');
            $table->integer('video_category_id')->unsigned()->nullable();
            $table->foreign('video_category_id')->references('id')->on('video_categories');
            $table->string('source');
            $table->integer('character_theme_id')->unsigned()->nullable();
            $table->foreign('character_theme_id')->references('id')->on('character_themes');
            $table->string('title');
            $table->string('description');
            $table->integer('display_order')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('videos')
            ->insert([
                [
                    'external_video_id'  => '278943779',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Intro Video',
                    'description'        => 'Intro Video',
                    'display_order'      => '100',
                ],
                [
                    'external_video_id'  => '278943907',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Day 1: Citizenship',
                    'description'        => 'Day 1: Citizenship',
                    'display_order'      => '200',
                ],
                [
                    'external_video_id'  => '278943914',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Day 2: Zest',
                    'description'        => 'Day 2: Zest',
                    'display_order'      => '300',
                ],
                [
                    'external_video_id'  => '278943920',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Day 3: Growth Mindset',
                    'description'        => 'Day 3: Growth Mindset',
                    'display_order'      => '400',
                ],
                [
                    'external_video_id'  => '278943926',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Day 4: Integrity',
                    'description'        => 'Day 4: Integrity',
                    'display_order'      => '500',
                ],
                [
                    'external_video_id'  => '278943935',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Day 5: Teamwork',
                    'description'        => 'Day 5: Teamwork',
                    'display_order'      => '600',
                ],
                [
                    'external_video_id'  => '278943944',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Day 6: Resolution',
                    'description'        => 'Day 6: Resolution',
                    'display_order'      => '700',
                ],
                [
                    'external_video_id'  => '278943769',
                    'video_category_id'  => '1',
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Get Pledges',
                    'description'        => 'Get Pledges',
                    'display_order'      => '800',
                ],
                [
                    'external_video_id'  => '279542990',
                    'video_category_id'  => null,
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Default Student Star',
                    'description'        => 'Default Student Star',
                    'display_order'      => '900',
                ],
                [
                    'external_video_id'  => '278943954',
                    'video_category_id'  => null,
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Teacher Welcome Video',
                    'description'        => 'Teacher Welcome Video',
                    'display_order'      => '1000',
                ],
                [
                    'external_video_id'  => 'Uv-IZDxdZbM',
                    'video_category_id'  => null,
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Booster Overview Video 2016',
                    'description'        => 'Booster Overview Video 2016',
                    'display_order'      => '1100',
                ],
                [
                    'external_video_id'  => 'Boosterthon Overview',
                    'video_category_id'  => null,
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Booster Overview Video Description',
                    'description'        => 'Booster Overview Video Description',
                    'display_order'      => '1200',
                ],
                [
                    'external_video_id'  => '9yzeWoelJ3M',
                    'video_category_id'  => null,
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'More Than A Run',
                    'description'        => 'More Than A Run',
                    'display_order'      => '1300',
                ],
                [
                    'external_video_id'  => '278943769',
                    'video_category_id'  => null,
                    'source'             => 'vimeo',
                    'character_theme_id' => null,
                    'title'              => 'Get Pledges Video',
                    'description'        => 'Get Pledges Video',
                    'display_order'      => '1400',
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
