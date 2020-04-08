<?php

use Illuminate\Database\Seeder;
use App\Entities\MicrositeVideo;

class MicrositeVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MicrositeVideo::class, 50)->make()->each(function ($video) {
            $video->save();
        });
    }
}
