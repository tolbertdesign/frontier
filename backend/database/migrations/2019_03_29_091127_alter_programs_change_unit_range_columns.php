<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProgramsChangeUnitRangeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            DB::unprepared('ALTER TABLE programs
                CHANGE COLUMN unit_min unit_range_low
                INT(10) unsigned NOT NULL DEFAULT 30');
            DB::unprepared('ALTER TABLE programs
                CHANGE COLUMN unit_max unit_max_charge
                INT(10) unsigned NOT NULL DEFAULT 35');
            $table->unsignedInteger('unit_range_high')->default(35);
            $table->unsignedInteger('no_units_entered_default')->default(30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            DB::unprepared('ALTER TABLE programs
                CHANGE COLUMN unit_range_low unit_min
                INT(10) unsigned NOT NULL DEFAULT 30');
            DB::unprepared('ALTER TABLE programs CHANGE COLUMN
                unit_max_charge unit_max INT(10)
                unsigned NOT NULL DEFAULT 35');
            $table->dropColumn('unit_range_high');
            $table->dropColumn('no_units_entered_default');
        });
    }
}
