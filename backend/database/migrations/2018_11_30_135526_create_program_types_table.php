<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('namespace');
            $table->string('sf_record_type_id');
        });

        DB::table('program_types')
            ->insert(
                [
                    'name'              => 'Giving Market',
                    'namespace'         => 'giving_market',
                    'sf_record_type_id' => '0120P000000AnufQAC',
                ]
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_types');
    }
}
