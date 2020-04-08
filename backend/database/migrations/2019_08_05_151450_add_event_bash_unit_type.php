<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventBashUnitType extends Migration
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
                    'title'               => 'Events - Bash',
                    'name'                => 'event',
                    'name_plural'         => 'events',
                    'modifier'            => 'per',
                    'multiplier_internal' => '32',
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
        DB::tables('units')->where('title', 'Events - Bash')->delete();
    }
}
