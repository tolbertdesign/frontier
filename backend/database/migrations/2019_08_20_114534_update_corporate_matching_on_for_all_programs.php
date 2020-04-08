<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCorporateMatchingOnForAllPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('show_corporate_matching_widget');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->boolean('show_corporate_matching_widget')->default(true);
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
            $table->dropColumn('show_corporate_matching_widget');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->boolean('show_corporate_matching_widget')->nullable()->default(null);
        });
    }
}
