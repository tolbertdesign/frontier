<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SyncUsersUserGroupsWithRoles extends Migration
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
            ADD COLUMN model_type varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "App\\\\User"
        ');
        DB::unprepared('
            ALTER TABLE model_has_roles
            MODIFY COLUMN model_type varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "App\\\\User"
        ');

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
        DB::unprepared('
            CREATE TRIGGER tr_sync_users_user_groups_with_model_has_roles_delete AFTER DELETE ON model_has_roles
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        DELETE FROM users_user_groups WHERE user_id = OLD.model_id AND group_id = OLD.role_id;
                    END IF;
                END;;
        ');

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
        DB::unprepared('
            CREATE TRIGGER tr_sync_model_has_roles_with_users_user_groups_delete AFTER DELETE ON users_user_groups
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        DELETE FROM model_has_roles WHERE model_id = OLD.user_id AND role_id = OLD.group_id;
                    END IF;
                END;;
        ');

        DB::unprepared('
            CREATE TRIGGER tr_sync_user_groups_with_roles_insert AFTER INSERT ON roles
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        INSERT INTO user_groups (
                            id,
                            name,
                            guard_name,
                            created_at,
                            updated_at,
                            description,
                            salesforce_id,
                            type,
                            deleted
                        )
                        values (
                            NEW.id,
                            NEW.name,
                            NEW.guard_name,
                            NEW.created_at,
                            NEW.updated_at,
                            NEW.description,
                            NEW.salesforce_id,
                            NEW.type,
                            NEW.deleted
                        );
                    END IF;
                END;;
        ');
        DB::unprepared('
            CREATE TRIGGER tr_sync_user_groups_with_roles_delete AFTER DELETE ON roles
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        DELETE FROM user_groups WHERE id = OLD.id;
                    END IF;
                END;;
        ');

        DB::unprepared('
            CREATE TRIGGER tr_sync_roles_with_user_groups_insert AFTER INSERT ON user_groups
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        INSERT INTO roles (
                            id,
                            name,
                            guard_name,
                            created_at,
                            updated_at,
                            description,
                            salesforce_id,
                            type,
                            deleted
                        )
                        values (
                            NEW.id,
                            NEW.name,
                            NEW.guard_name,
                            NEW.created_at,
                            NEW.updated_at,
                            NEW.description,
                            NEW.salesforce_id,
                            NEW.type,
                            NEW.deleted
                        );
                    END IF;
                END;;
        ');
        DB::unprepared('
            CREATE TRIGGER tr_sync_roles_with_user_groups_delete AFTER DELETE ON user_groups
                FOR EACH ROW
                BEGIN
                    IF @__disable_trigger_t1t2 = 1 THEN
                        SET @__disable_trigger_t1t2 = NULL;
                    ELSE
                        SET @__disable_trigger_t1t2 = 1;
                        DELETE FROM roles WHERE id = OLD.id;
                    END IF;
                END;;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_sync_users_user_groups_with_model_has_roles_insert`');
        DB::unprepared('DROP TRIGGER `tr_sync_users_user_groups_with_model_has_roles_delete`');

        DB::unprepared('DROP TRIGGER `tr_sync_model_has_roles_with_users_user_groups_insert`');
        DB::unprepared('DROP TRIGGER `tr_sync_model_has_roles_with_users_user_groups_delete`');

        DB::unprepared('DROP TRIGGER `tr_sync_user_groups_with_roles_insert`');
        DB::unprepared('DROP TRIGGER `tr_sync_user_groups_with_roles_delete`');

        DB::unprepared('DROP TRIGGER `tr_sync_roles_with_user_groups_insert`');
        DB::unprepared('DROP TRIGGER `tr_sync_roles_with_user_groups_delete`');
    }
}
