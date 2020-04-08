<?php
// @codingStandardsIgnoreFile

use App\Entities\Participant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetFamilyPledgingForParticipantsWithNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Find all participants WITH siblings and update null family_pledging_enabled to on
        $doubles = DB::select(DB::raw('SELECT
                users.id
           FROM
                participants
                JOIN users ON users.id = participants.user_id
                JOIN classrooms ON classrooms.id = participants.classroom_id
                JOIN `groups` ON groups.id = classrooms.group_id
                JOIN programs ON programs.id = groups.program_id
                JOIN students_parents ON users.id = students_parents.student_id
                JOIN (
                    SELECT
                        parent_id,
                        student_id,
                        program_id
                    FROM
                        students_parents
                        JOIN participants ON students_parents.student_id = participants.user_id
                        JOIN users ON participants.user_id = users.id
                        JOIN classrooms ON classrooms.id = participants.classroom_id
                        JOIN `groups` ON groups.id = classrooms.group_id
                        JOIN programs ON programs.id = groups.program_id
                        LEFT JOIN users_user_groups ON users_user_groups.user_id = students_parents.student_id
                            AND users_user_groups.group_id = 7
                    WHERE
                        programs.semester = "2019-2-Fall"
                        AND users.deleted = 0
                        AND classrooms.deleted = 0
                        AND users.reg_code_temp_user = 0
                        AND users_user_groups.group_id IS NULL) AS sibling ON sibling.parent_id = students_parents.parent_id
                AND sibling.student_id != students_parents.student_id
                AND sibling.program_id = programs.id
                LEFT JOIN users_user_groups ON users_user_groups.user_id = participants.user_id
                    AND users_user_groups.group_id = 7
            WHERE
                programs.semester = "2019-2-Fall"
                AND participants.family_pledging_enabled IS NULL
                AND users.deleted = 0
                AND classrooms.deleted = 0
                AND users.reg_code_temp_user = 0
                AND users_user_groups.group_id IS NULL
            GROUP BY
                users.id'));
        $doubles = array_map(
            function ($d) {
                return $d->id;
            },
            $doubles
        );
        Participant::whereIn('user_id', $doubles)->update(['family_pledging_enabled' => 1]);

        //Find all participants WITHOUT siblings and update null family_pledging_enabled to off
        $singles = DB::select(DB::raw('SELECT
                users.id
            FROM
                participants
                JOIN users ON users.id = participants.user_id
                JOIN classrooms ON classrooms.id = participants.classroom_id
                JOIN `groups` ON groups.id = classrooms.group_id
                JOIN programs ON programs.id = groups.program_id
                LEFT JOIN users_user_groups ON users_user_groups.user_id = participants.user_id
                    AND users_user_groups.group_id = 7
            WHERE
                programs.semester = "2019-2-Fall"
                AND participants.family_pledging_enabled IS NULL
                AND users.deleted = 0
                AND classrooms.deleted = 0
                AND users.reg_code_temp_user = 0
                AND users_user_groups.group_id IS NULL'));
        $singles = array_map(
            function ($d) {
                return $d->id;
            },
            $singles
        );
        //filter just in case of replication lag for read
        $singles = array_diff($singles, $doubles);
        Participant::whereIn('user_id', $singles)->update(['family_pledging_enabled' => 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //No Down
    }
}
