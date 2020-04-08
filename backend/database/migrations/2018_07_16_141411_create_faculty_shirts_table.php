<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyShirtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('faculty_shirts')) {
            Schema::create('faculty_shirts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('classroom_id');
                $table->unsignedMediumInteger('youth_s');
                $table->unsignedMediumInteger('youth_m');
                $table->unsignedMediumInteger('youth_l');
                $table->unsignedMediumInteger('adult_s');
                $table->unsignedMediumInteger('adult_m');
                $table->unsignedMediumInteger('adult_l');
                $table->unsignedMediumInteger('adult_xl');
                $table->unsignedMediumInteger('adult_2xl');
                $table->unsignedMediumInteger('adult_3xl');
                $table->unsignedMediumInteger('adult_4xl');
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
        Schema::dropIfExists('faculty_shirts');
    }
}
