<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('units')) {
            Schema::create('units', function ($table) {
                $table->increments('id')->unsigned();
                $table->string('title', 25);
                $table->string('name', 25);
                $table->string('name_plural', 25);
                $table->string('modifier', 10)->nullable();
                $table->integer('multiplier_internal')->unsigned();
                $table->integer('default_multiplier')->unsigned();
                $table->integer('default_lower_limit')->unsigned();
                $table->integer('default_upper_limit')->unsigned();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unit_datas');
    }
}
