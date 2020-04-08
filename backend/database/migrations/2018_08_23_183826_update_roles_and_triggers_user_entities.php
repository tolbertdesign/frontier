<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRolesAndTriggersUserEntities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            ALTER TABLE users_user_groups
            MODIFY COLUMN model_type varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "App\\\\Entities\\\\User"
        ');
        DB::unprepared('
            ALTER TABLE model_has_roles
            MODIFY COLUMN model_type varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "App\\\\Entities\\\\User"
        ');

        DB::unprepared('DROP TRIGGER `tr_sync_users_user_groups_with_model_has_roles_insert`');
        DB::unprepared('
            CREATE TRIGGER tr_sync_users_user_groups_with_model_has_roles_insert AFTER INSERT ON model_has_roles
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        INSERT INTO users_user_groups (user_id, group_id, model_type)
                            values (NEW.model_id, NEW.role_id, "App\\\\Entities\\\\User");
                    END IF;
                END;;
        ');
        DB::unprepared('DROP TRIGGER `tr_sync_model_has_roles_with_users_user_groups_insert`');
        DB::unprepared('
            CREATE TRIGGER tr_sync_model_has_roles_with_users_user_groups_insert AFTER INSERT ON users_user_groups
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        INSERT INTO model_has_roles (model_id, role_id, model_type)
                            values (NEW.user_id, NEW.group_id, "App\\\\Entities\\\\User");
                    END IF;
                END;;
        ');
        DB::unprepared('UPDATE model_has_roles SET model_type="App\\\\Entitites\\\\User"');
        DB::unprepared('UPDATE users_user_groups SET model_type="App\\\\Entitites\\\\User"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_sync_users_user_groups_with_model_has_roles_insert`');
        DB::unprepared('
            CREATE TRIGGER tr_sync_users_user_groups_with_model_has_roles_insert AFTER INSERT ON model_has_roles
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        INSERT INTO users_user_groups (user_id, group_id, model_type)
                            values (NEW.model_id, NEW.role_id, "App\\\\User");
                    END IF;
                END;;
        ');
        DB::unprepared('DROP TRIGGER `tr_sync_model_has_roles_with_users_user_groups_insert`');
        DB::unprepared('
            CREATE TRIGGER tr_sync_model_has_roles_with_users_user_groups_insert AFTER INSERT ON users_user_groups
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        INSERT INTO model_has_roles (model_id, role_id, model_type)
                            values (NEW.user_id, NEW.group_id, "App\\\\User");
                    END IF;
                END;;
        ');
    }
}
