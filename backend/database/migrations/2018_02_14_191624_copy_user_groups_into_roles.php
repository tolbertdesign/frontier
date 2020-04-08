<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CopyUserGroupsIntoRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::insert(
            'insert into roles (id, name, guard_name, created_at, updated_at, description, salesforce_id, type, deleted)
            (SELECT id, name, "web", NOW(), NOW(), description, salesforce_id, type, deleted FROM user_groups)'
        );

        DB::insert(
            'INSERT INTO model_has_roles (role_id, model_id, model_type)
            (SELECT group_id, user_id, "App\\\\User" FROM users_user_groups)'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
