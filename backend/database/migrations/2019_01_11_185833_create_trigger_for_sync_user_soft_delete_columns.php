<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerForSyncUserSoftDeleteColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER sync_user_soft_delete_columns BEFORE UPDATE ON users
            FOR EACH ROW
            BEGIN
                IF (NEW.deleted = 1 AND (OLD.deleted = 0 OR OLD.deleted IS NULL))
                    THEN SET NEW.deleted_at = current_date();
                ELSEIF ((NEW.deleted = 0 OR NEW.deleted IS NULL) AND OLD.deleted = 1)
                    THEN SET NEW.deleted_at = null;
                ELSEIF (NEW.deleted_at IS NOT NULL)
                    THEN SET NEW.deleted = 1;
                ELSEIF (NEW.deleted_at IS NULL)
                    THEN SET NEW.deleted = 0;
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
        DB::unprepared('DROP TRIGGER `sync_user_soft_delete_columns`');
    }
}
