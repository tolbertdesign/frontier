<?php

use Illuminate\Database\Seeder;
use App\Entities\MicrositePic;

class MicrositePicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MicrositePic::class, 50)->make()->each(function ($pic) {
            $pic->save();
        });
    }
}
