<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPrizesBoundTableAddStartsAtAndEndsAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prizes_bound', function (Blueprint $table) {
            $table->dateTime('starts_at')->nullable()->default(null);
            $table->dateTime('ends_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prizes_bound', function ($table) {
            $table->dropColumn('starts_at');
            $table->dropColumn('ends_at');
        });
    }
}
