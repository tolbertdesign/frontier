<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAccessTokensTableAddUserIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_tokens', function (Blueprint $table) {
            $indexesFound = collect(DB::select("SHOW INDEXES FROM access_tokens"))->pluck('Key_name');
            if (empty($indexesFound->contains('access_tokens_user_id_unique'))) {
                $table->unique('user_id');
            }
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_tokens', function (Blueprint $table) {
            $table->dropUnique('user_id');
        });
    }
}
