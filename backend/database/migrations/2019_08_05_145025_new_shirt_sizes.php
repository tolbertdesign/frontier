<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NewShirtSizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //cant do mediumint(5) with laravel schema
        DB::statement('ALTER TABLE classroom_shirts ADD youth_xs ' .
            ' MEDIUMINT(5) unsigned DEFAULT NULL AFTER classroom_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classroom_shirts', function (Blueprint $table) {
            $table->dropColumn('youth_xs');
        });
    }
}
