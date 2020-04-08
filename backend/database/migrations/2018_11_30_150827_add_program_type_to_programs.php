<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProgramTypeToPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->integer('program_type_id')->unsigned()->nullable();
            $table->foreign('program_type_id')->references('id')->on('program_types');
        });

        $program_type_giving_market = DB::table('program_types')->where('namespace', 'giving_market')->first();

        //Initial seeder function to assign giving market programs the correct program_type_id
        DB::table('programs')
            ->where('name', 'like', '%gvmk%')
            ->update([
                'program_type_id' => $program_type_giving_market->id,
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function ($table) {
            $table->dropColumn('program_type_id');
        });
    }
}
