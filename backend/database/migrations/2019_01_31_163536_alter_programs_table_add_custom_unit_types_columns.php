<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProgramsTableAddCustomUnitTypesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->integer('unit_min')->unsigned()->default(30);
            $table->integer('unit_max')->unsigned()->default(35);
            $table->integer('unit_estimated_average')->unsigned()->default(33);
            $table->integer('unit_flat_conversion')->unsigned()->default(30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function ($table) {
            $table->dropColumn('unit_min');
            $table->dropColumn('unit_max');
            $table->dropColumn('unit_estimated_average');
            $table->dropColumn('unit_flat_conversion');
        });
    }
}
