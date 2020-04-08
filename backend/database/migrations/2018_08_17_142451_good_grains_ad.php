<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\ProgramSponsorAd;
use App\Entities\ProgramSponsor;
use App\Entities\AdLocation;

class GoodGrainsAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //@codingStandardsIgnoreStart
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ProgramSponsorAd::insert([
            [
                'id'                 => '4',
                'program_sponsor_id' => '2',
                'ad_text'            => '<div style="display:inline-block; max-width:100%;"><a style="max-width:100%" target="_blank" href="https://goodgrains.com/booster"><img style="max-width:100%" src="/assets/images/good-grains-desktop.png"/></a></div>',
            ], [
                'id'                 => '5',
                'program_sponsor_id' => '2',
                'ad_text'            => '<div style="display:inline-block; max-width:100%;"><a style="max-width:100%" target="_blank" href="https://goodgrains.com/booster"><img style="max-width:100%" src="/assets/images/good-grains-mobile.png"/></a></div>',
            ]
        ]);
        //@codingStandardsIgnoreEnd

        DB::table('program_sponsor_ad_locations')->insert([
            [
                'program_sponsor_ad_id' => 4,
                'ad_location_id'        => 1,
            ], [
                'program_sponsor_ad_id' => 5,
                'ad_location_id'        => 8,
            ]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('delete from program_sponsor_ad_locations where program_sponsor_ad_id = 4 and ad_location_id = 1');
        DB::delete('delete from program_sponsor_ad_locations where program_sponsor_ad_id = 5 and ad_location_id = 8');
        DB::delete('delete from program_sponsor_ads where id in(4,5)');
    }
}
