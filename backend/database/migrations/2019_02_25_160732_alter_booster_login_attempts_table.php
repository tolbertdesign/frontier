<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBoosterLoginAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booster_login_attempts', function (Blueprint $table) {
            $table->tinyInteger('blocked')->default(0);
            $table->string('metadata', 1023)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booster_login_attempts', function ($table) {
            $table->dropColumn('blocked');
            $table->dropColumn('metadata');
        });
    }
}
