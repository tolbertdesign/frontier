<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBoosterthonOverviewRetroactively extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('microsites')
            ->join('programs', 'microsites.program_id', '=', 'programs.id')
            ->where('programs.pep_rally', '>', '2018-06-01')
            ->where(function ($query) {
                $query->whereNull('video_3')->orWhere('video_3', '');
            })->update(['video_3' => 5336]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
