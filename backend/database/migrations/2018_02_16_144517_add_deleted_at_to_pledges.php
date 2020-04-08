<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

class AddDeletedAtToPledges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pledges', function (Blueprint $table) {
            $table->softDeletes();
        });

        DB::table('pledges')->where('deleted', 1)->update(['deleted_at' => Illuminate\Support\Carbon::now()]);

        DB::unprepared("
        DROP TRIGGER paid_pledge_check;
        CREATE TRIGGER tr_pledge_update BEFORE UPDATE ON pledges
            FOR EACH ROW BEGIN
                IF @SKIP_TRIGGER != TRUE
                AND OLD.pledge_status_id = 3
                AND NEW.pledge_status_id <> OLD.pledge_status_id THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot update paid pledge.';
                END IF;
                IF NEW.deleted_at IS NOT NULL AND OLD.deleted_at IS NULL THEN
                    SET NEW.deleted = 1;
                    SET NEW.ts_deleted = NEW.deleted_at;
                ELSEIF NEW.deleted_at IS NULL and OLD.deleted_at IS NOT NULL THEN
                    SET NEW.deleted = 0;
                    SET NEW.ts_deleted = NEW.deleted_at;
                END IF;

                IF NEW.deleted = 1 AND OLD.deleted = 0 THEN
                    SET NEW.deleted_at = CURRENT_TIMESTAMP;
                ELSEIF NEW.deleted = 0 and OLD.deleted = 1 THEN
                    SET NEW.deleted_at = NULL;
                END IF;
            END;;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pledges', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        DB::unprepared('DROP TRIGGER `tr_pledge_update`');
    }
}
