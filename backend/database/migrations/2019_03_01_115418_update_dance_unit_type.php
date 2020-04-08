<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDanceUnitType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('units')
            ->where('name', 'dance')
            ->update([
                'title'       => 'Dance Move',
                'name'        => 'dance move',
                'name_plural' => 'dance moves',
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('units')
            ->where('name', 'dance move')
            ->update([
                'title'       => 'Dance',
                'name'        => 'dance',
                'name_plural' => 'dances',
            ]);
    }
}
