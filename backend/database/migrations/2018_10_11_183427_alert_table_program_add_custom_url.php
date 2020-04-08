<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertTableProgramAddCustomUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('UPDATE programs SET due_date = NULL WHERE due_date < "1001-01-01 00:00:01"');
        Schema::table('programs', function ($table) {
            $table->string('custom_url', 40)->nullable()->default(null)->unique()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('programs', 'custom_url')) {
            Schema::table('programs', function ($table) {
                $table->dropColumn('custom_url');
            });
        }
    }
}
