<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrackLevelUp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pledges', function (Blueprint $table) {
            $table->boolean('saw_level_up')->default(false);
            $table->boolean('accepted_level_up')->default(false);
            $table->decimal('level_up_difference')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pledges', function (Blueprint $table) {
            $table->dropColumn('saw_level_up');
            $table->dropColumn('accepted_level_up');
            $table->dropColumn('level_up_difference');
        });
    }
}
