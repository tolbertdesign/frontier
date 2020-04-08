<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFitnessChallengeUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('units')
            ->insert(
                [
                    'id'                  => 5,
                    'title'               => 'Fitness Challenge',
                    'name'                => 'fitness challenge',
                    'name_plural'         => 'fitness challenges',
                    'modifier'            => 'per',
                    'multiplier_internal' => '33',
                    'default_multiplier'  => '30',
                    'default_lower_limit' => '30',
                    'default_upper_limit' => '35',
                    'created_at'          => date('Y-m-d H:i:s'),
                    'updated_at'          => date('Y-m-d H:i:s'),
                ]
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('units')
            ->where('name', 'fitness challenge')
            ->delete();
    }
}
