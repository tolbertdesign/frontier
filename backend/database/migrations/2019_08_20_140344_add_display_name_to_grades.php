<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\Grade;

class AddDisplayNameToGrades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('display_name')->default('');
        });

        Grade::where('id', '>', 0)->update(
            ['display_name' => DB::raw('CONCAT(name, " Grade")')]
        );

        Grade::whereIn('id', [0, -1])->update(
            ['display_name' => DB::raw('CONCAT(name)')]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('display_name');
        });
    }
}
