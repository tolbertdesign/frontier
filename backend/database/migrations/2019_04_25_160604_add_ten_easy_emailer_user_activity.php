<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTenEasyEmailerUserActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('user_activities')
            ->insert(
                [
                    'name'       => '10 Easy Emails',
                    'created_on' => date('Y-m-d H:i:s'),
                ]
            );
        DB::table('user_activities')
            ->insert(
                [
                    'name'       => '15 Easy Emails',
                    'created_on' => date('Y-m-d H:i:s'),
                ]
            );
        DB::table('user_activities')
            ->insert(
                [
                    'name'       => '20 Easy Emails',
                    'created_on' => date('Y-m-d H:i:s'),
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
        DB::table('user_activities')
            ->where('name', '10 Easy Emails')
            ->delete();
        DB::table('user_activities')
            ->where('name', '15 Easy Emails')
            ->delete();
        DB::table('user_activities')
            ->where('name', '20 Easy Emails')
            ->delete();
    }
}
