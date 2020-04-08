<?php
// @codingStandardsIgnoreFile

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImportViewsFromTrapperkeeper extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //dead function
        if (in_array(env('APP_ENV'), ['local', 'dev', 'testing'])) {
            $this->doNotRunOnProd();
        }
    }

    private function doNotRunOnProd()
    {
        if (in_array(env('APP_ENV'), ['local', 'dev'])) {
            DB::statement("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        }
        if (in_array(env('APP_ENV'), ['local', 'dev', 'testing'])) {
            DB::statement('DROP VIEW IF EXISTS `view_program_payments`;');
            DB::statement('CREATE
            VIEW `view_program_payments` AS
                SELECT
                    `Split`.`add_to_envelope` AS `add_to_envelope`,
                    `payments`.`id` AS `id`,
                    `payments`.`entered_by_name` AS `entered_by_name`,
                    `payments`.`created_at` AS `created_at`,
                    `payments`.`first_name` AS `first_name`,
                    `payments`.`last_name` AS `last_name`,
                    CAST(`payments`.`created_at` AS DATE) AS `entered_date`,
                    CONCAT(`payments`.`last_name`,
                            \', \',
                            `payments`.`first_name`) AS `last_first_name`,
                    `payments`.`amount` AS `amount`,
                    `payments`.`note` AS `note`,
                    `payments`.`address` AS `address`,
                    `payments`.`phone` AS `phone`,
                    `payments`.`city` AS `city`,
                    `payments`.`state` AS `state`,
                    `payments`.`zip` AS `zip`,
                    `payments`.`receipt` AS `receipt`,
                    `Split`.`student_id` AS `student_id`,
                    `Split`.`amount` AS `split_amount`,
                    `Student`.`first_name` AS `student_first_name`,
                    `Student`.`last_name` AS `student_last_name`,
                    CONCAT(`Student`.`first_name`,
                            \' \',
                            `Student`.`last_name`) AS `student_first_last`,
                    IFNULL(`manual_payments`.`type`, \'CC\') AS `type`,
                    `manual_payments`.`check_number` AS `check_number`,
                    IFNULL(`manual_payments`.`classroom_id`,
                            `classrooms`.`id`) AS `classroom_id`,
                    `groups`.`program_id` AS `program_id`,
                    `classrooms`.`id` AS `participant_classroom_id`
                FROM
                    (((((((`payments`
                    LEFT JOIN `manual_payments` ON ((`manual_payments`.`payment_id` = `payments`.`id`)))
                    LEFT JOIN `online_payments` ON ((`online_payments`.`payment_id` = `payments`.`id`)))
                    JOIN `payments_students` `Split` ON ((`Split`.`payment_id` = `payments`.`id`)))
                    JOIN `users` `Student` ON ((`Student`.`id` = `Split`.`student_id`)))
                    JOIN `participants` ON ((`participants`.`user_id` = `Split`.`student_id`)))
                    JOIN `classrooms` ON ((`classrooms`.`id` = `participants`.`classroom_id`)))
                    JOIN `groups` ON ((`groups`.`id` = `classrooms`.`group_id`)))
                WHERE
                    ((`payments`.`deleted` = 0) AND (`Split`.`deleted` = 0))');

            DB::statement('DROP VIEW IF EXISTS `view_school`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_school` AS
                SELECT
                    `schools`.`id` AS `id`,
                    IFNULL(COALESCE(`schools`.`timezone`,
                                    `usa_zip`.`timezone`),
                            \'America/New_York\') AS `tz`,
                    IF((COALESCE(`schools`.`timezone`,
                                `usa_zip`.`timezone`) IS NOT NULL),
                        \'(School timezone)\',
                        NULL) AS `tz_known`
                FROM
                    (`schools`
                    LEFT JOIN `usa_zip` ON ((`usa_zip`.`zipcode` = `schools`.`zip`)))');

            DB::statement('DROP VIEW IF EXISTS `view_program_collection`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_collection` AS
                SELECT
                    `view_program_payments`.`program_id` AS `program_id`,
                    `view_program_payments`.`add_to_envelope` AS `add_to_envelope`,
                    `view_program_payments`.`student_id` AS `student_id`,
                    SUM(IF((CURDATE() = `view_program_payments`.`entered_date`),
                        `view_program_payments`.`split_amount`,
                        NULL)) AS `envelope`,
                    SUM(IF((\'CC\' = `view_program_payments`.`type`),
                        `view_program_payments`.`split_amount`,
                        0.00)) AS `cc`,
                    SUM(IF((\'CASH\' = `view_program_payments`.`type`),
                        `view_program_payments`.`split_amount`,
                        0.00)) AS `cash`,
                    SUM(IF((\'CHECK\' = `view_program_payments`.`type`),
                        `view_program_payments`.`split_amount`,
                        0.00)) AS `check`,
                    SUM(`view_program_payments`.`split_amount`) AS `collected`
                FROM
                    `view_program_payments`
                GROUP BY `view_program_payments`.`program_id` ,
                `view_program_payments`.`student_id` ,
                \'utf8\' ,
                \'utf8_general_ci\'');


            DB::statement('DROP VIEW IF EXISTS `view_program_collection_payments`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_collection_payments` AS
                SELECT
                    `view_program_payments`.`program_id` AS `program_id`,
                    `view_program_payments`.`student_id` AS `student_id`,
                    SUM(IF((CURDATE() = `view_program_payments`.`entered_date`),
                        `view_program_payments`.`split_amount`,
                        NULL)) AS `envelope`,
                    SUM(`view_program_payments`.`split_amount`) AS `collected`
                FROM
                    `view_program_payments`
                GROUP BY `view_program_payments`.`program_id` , `view_program_payments`.`student_id`');


            DB::statement('DROP VIEW IF EXISTS `view_program_parts`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_parts` AS
                SELECT
                    `users`.`id` AS `id`,
                    `users`.`first_name` AS `first_name`,
                    `users`.`last_name` AS `last_name`,
                    `users`.`fr_code` AS `fr_code`,
                    `users`.`laps` AS `laps`,
                    `users`.`last_login` AS `last_login`,
                    IF(`users`.`registered`, 1, NULL) AS `login_status`,
                    `grades`.`name` AS `grade_name`,
                    `participants`.`classroom_id` AS `classroom_id`,
                    `classrooms`.`name` AS `class`,
                    `classrooms`.`grade_id` AS `grade_id`,
                    `classrooms`.`group_id` AS `group_id`,
                    `groups`.`program_id` AS `program_id`,
                    `groups`.`name` AS `group_name`,
                    `users_user_groups`.`group_id` AS `user_group_id`,
                    MAX(`users_notes`.`last_updated`) AS `note_date`
                FROM
                    ((((((`users`
                    JOIN `participants` ON ((`participants`.`user_id` = `users`.`id`)))
                    JOIN `users_user_groups` ON ((`users_user_groups`.`user_id` = `users`.`id`)))
                    LEFT JOIN `users_notes` ON ((`users_notes`.`user_id` = `users`.`id`)))
                    JOIN `classrooms` ON ((`classrooms`.`id` = `participants`.`classroom_id`)))
                    JOIN `groups` ON ((`groups`.`id` = `classrooms`.`group_id`)))
                    JOIN `grades` ON ((`classrooms`.`grade_id` = `grades`.`id`)))
                WHERE
                    ((NOT (`users`.`deleted`))
                        AND (`users`.`first_name` IS NOT NULL)
                        AND (`users`.`last_name` IS NOT NULL)
                        AND (`groups`.`program_id` = PROGRAM_ID()))
                GROUP BY `users`.`id`');



            DB::statement('DROP VIEW IF EXISTS `view_program_pledges`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_pledges` AS
                SELECT
                    `pledges`.`id` AS `id`,
                    CONCAT(`users`.`first_name`,
                            \' \',
                            `users`.`last_name`) AS `participant_name`,
                    CONCAT(`PledgeSponsor`.`first_name`,
                            \' \',
                            `PledgeSponsor`.`last_name`) AS `sponsor_name`,
                    `Sponsor`.`phone` AS `sponsor_phone`,
                    `classrooms`.`name` AS `class`,
                    `pledges`.`amount` AS `amount`,
                    `pledge_types`.`long_name` AS `pledge_type`,
                    `pledge_types`.`name` AS `pledge_type_short`,
                    FORMAT((`pledges`.`amount` * `pledge_types`.`multiplier_low`),
                        2) AS `total_low`,
                    FORMAT((`pledges`.`amount` * `pledge_types`.`multiplier_high`),
                        2) AS `total_high`,
                    `pledges`.`pledge_status_id` AS `pledge_status_id`,
                    `pledge_statuses`.`name` AS `status`,
                    `pledges`.`pledge_substatus_id` AS `pledge_substatus_id`,
                    `pledges`.`program_id` AS `program_id`,
                    `pledges`.`participant_user_id` AS `participant_user_id`,
                    `pledges`.`user_id` AS `sponsor_id`,
                    `pledges`.`pledge_sponsor_id` AS `pledge_sponsor_id`,
                    `pledges`.`sponsor_type_id` AS `sponsor_type_id`,
                    `pledges`.`pledge_type_id` AS `pledge_type_id`,
                    `users`.`laps` AS `laps`,
                    `participants`.`classroom_id` AS `classroom_id`,
                    IF((`pledges`.`pledge_status_id` IN (2 , 4)),
                        `pledges`.`amount`,
                        NULL) AS `amount_confirmed_or_pending`,
                    `view_school`.`tz_known` AS `tz_known`,
                    DATE_FORMAT(IFNULL(CONVERT_TZ(`pledges`.`ts_entered`,
                                            \'America/New_York\',
                                            `view_school`.`tz`),
                                    `pledges`.`ts_entered`),
                            \'%c/%d/%y %h:%i %p\') AS `ts_entered_tz`,
                    DATE_FORMAT(IFNULL(CONVERT_TZ(`pledges`.`ts_updated`,
                                            \'America/New_York\',
                                            `view_school`.`tz`),
                                    `pledges`.`ts_updated`),
                            \'%c/%d/%y %h:%i %p\') AS `ts_updated_tz`,
                    DATE_FORMAT(IFNULL(CONVERT_TZ(`pledges`.`ts_confirmed`,
                                            \'America/New_York\',
                                            `view_school`.`tz`),
                                    `pledges`.`ts_confirmed`),
                            \'%c/%d/%y %h:%i %p\') AS `ts_confirmed_tz`,
                    (CASE `pledge_types`.`name`
                        WHEN
                            \'PPL\'
                        THEN
                            IF(ISNULL(`users`.`laps`),
                                0,
                                (`pledges`.`amount` * IF((`users`.`laps` = 0),
                                    `pledge_types`.`multiplier_average`,
                                    `users`.`laps`)))
                        WHEN \'Flat\' THEN `pledges`.`amount`
                    END) AS `total`,
                    (`pledges`.`amount` * (CASE `pledge_types`.`name`
                        WHEN
                            \'PPL\'
                        THEN
                            IF((ISNULL(`users`.`laps`)
                                    OR (`users`.`laps` = 0)),
                                `pledge_types`.`multiplier_average`,
                                `users`.`laps`)
                        WHEN \'Flat\' THEN 1
                    END)) AS `total_est`,
                    (CASE `pledge_types`.`name`
                        WHEN
                            \'PPL\'
                        THEN
                            (CASE
                                WHEN
                                    ISNULL(`users`.`laps`)
                                THEN
                                    CONCAT(\'$\',
                                            (`pledges`.`amount` * `pledge_types`.`multiplier_low`),
                                            \' - $\',
                                            (`pledges`.`amount` * `pledge_types`.`multiplier_high`))
                                WHEN
                                    (`users`.`laps` = 0)
                                THEN
                                    CONCAT(\'$\',
                                            (`pledges`.`amount` * `pledge_types`.`multiplier_average`))
                                ELSE CONCAT(\'$\',
                                        (`pledges`.`amount` * `users`.`laps`))
                            END)
                        WHEN \'Flat\' THEN CONCAT(\'$\', `pledges`.`amount`)
                    END) AS `range_est`,
                    `programs`.`archived` AS `archived`,
                    `programs`.`unit_id` AS `unit_id`
                FROM
                    ((((((((((`pledges`
                    LEFT JOIN `users` `Sponsor` ON ((`Sponsor`.`id` = `pledges`.`user_id`)))
                    LEFT JOIN `pledge_sponsors` `PledgeSponsor` ON ((`PledgeSponsor`.`id` = `pledges`.`pledge_sponsor_id`)))
                    JOIN `users` ON ((`users`.`id` = `pledges`.`participant_user_id`)))
                    LEFT JOIN `participants` ON ((`participants`.`user_id` = `pledges`.`participant_user_id`)))
                    JOIN `classrooms` ON ((`classrooms`.`id` = `participants`.`classroom_id`)))
                    JOIN `groups` ON ((`groups`.`id` = `classrooms`.`group_id`)))
                    JOIN `programs` ON ((`programs`.`id` = `groups`.`program_id`)))
                    LEFT JOIN `view_school` ON ((`view_school`.`id` = `programs`.`school_id`)))
                    JOIN `pledge_types` ON ((`pledge_types`.`id` = `pledges`.`pledge_type_id`)))
                    JOIN `pledge_statuses` ON ((`pledge_statuses`.`id` = `pledges`.`pledge_status_id`)))
                WHERE
                    ((NOT (`pledges`.`deleted`))
                        AND (NOT (`users`.`deleted`)))');


            DB::statement('DROP VIEW IF EXISTS `view_program_pledges_deleted`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_pledges_deleted` AS
                SELECT
                    `pledges`.`id` AS `id`,
                    CONCAT(`users`.`first_name`,
                            \' \',
                            `users`.`last_name`) AS `participant_name`,
                    CONCAT(`PledgeSponsor`.`first_name`,
                            \' \',
                            `PledgeSponsor`.`last_name`) AS `sponsor_name`,
                    `Sponsor`.`phone` AS `sponsor_phone`,
                    `classrooms`.`name` AS `class`,
                    `pledges`.`amount` AS `amount`,
                    `pledge_types`.`long_name` AS `pledge_type`,
                    `pledge_types`.`name` AS `pledge_type_short`,
                    FORMAT((`pledges`.`amount` * `pledge_types`.`multiplier_low`),
                        2) AS `total_low`,
                    FORMAT((`pledges`.`amount` * `pledge_types`.`multiplier_high`),
                        2) AS `total_high`,
                    `pledges`.`pledge_status_id` AS `pledge_status_id`,
                    `pledge_statuses`.`name` AS `status`,
                    `pledges`.`pledge_substatus_id` AS `pledge_substatus_id`,
                    `pledges`.`program_id` AS `program_id`,
                    `pledges`.`participant_user_id` AS `participant_user_id`,
                    `pledges`.`user_id` AS `sponsor_id`,
                    `pledges`.`pledge_sponsor_id` AS `pledge_sponsor_id`,
                    `pledges`.`sponsor_type_id` AS `sponsor_type_id`,
                    `pledges`.`pledge_type_id` AS `pledge_type_id`,
                    `users`.`laps` AS `laps`,
                    `participants`.`classroom_id` AS `classroom_id`,
                    IF((`pledges`.`pledge_status_id` IN (2 , 4)),
                        `pledges`.`amount`,
                        NULL) AS `amount_confirmed_or_pending`,
                    `view_school`.`tz_known` AS `tz_known`,
                    DATE_FORMAT(IFNULL(CONVERT_TZ(`pledges`.`ts_entered`,
                                            \'SYSTEM\',
                                            `view_school`.`tz`),
                                    `pledges`.`ts_entered`),
                            \'%c/%d/%y %h:%i %p\') AS `ts_entered_tz`,
                    DATE_FORMAT(IFNULL(CONVERT_TZ(`pledges`.`ts_updated`,
                                            \'SYSTEM\',
                                            `view_school`.`tz`),
                                    `pledges`.`ts_updated`),
                            \'%c/%d/%y %h:%i %p\') AS `ts_updated_tz`,
                    DATE_FORMAT(IFNULL(CONVERT_TZ(`pledges`.`ts_confirmed`,
                                            \'SYSTEM\',
                                            `view_school`.`tz`),
                                    `pledges`.`ts_confirmed`),
                            \'%c/%d/%y %h:%i %p\') AS `ts_confirmed_tz`,
                    (CASE `pledge_types`.`name`
                        WHEN
                            \'PPL\'
                        THEN
                            IF(ISNULL(`users`.`laps`),
                                0,
                                (`pledges`.`amount` * IF((`users`.`laps` = 0),
                                    `pledge_types`.`multiplier_average`,
                                    `users`.`laps`)))
                        WHEN \'Flat\' THEN `pledges`.`amount`
                    END) AS `total`,
                    (`pledges`.`amount` * (CASE `pledge_types`.`name`
                        WHEN
                            \'PPL\'
                        THEN
                            IF((ISNULL(`users`.`laps`)
                                    OR (`users`.`laps` = 0)),
                                `pledge_types`.`multiplier_average`,
                                `users`.`laps`)
                        WHEN \'Flat\' THEN 1
                    END)) AS `total_est`,
                    (CASE `pledge_types`.`name`
                        WHEN
                            \'PPL\'
                        THEN
                            (CASE
                                WHEN
                                    ISNULL(`users`.`laps`)
                                THEN
                                    CONCAT(\'$\',
                                            (`pledges`.`amount` * `pledge_types`.`multiplier_low`),
                                            \' - $\',
                                            (`pledges`.`amount` * `pledge_types`.`multiplier_high`))
                                WHEN
                                    (`users`.`laps` = 0)
                                THEN
                                    CONCAT(\'$\',
                                            (`pledges`.`amount` * `pledge_types`.`multiplier_average`))
                                ELSE CONCAT(\'$\',
                                        (`pledges`.`amount` * `users`.`laps`))
                            END)
                        WHEN \'Flat\' THEN CONCAT(\'$\', `pledges`.`amount`)
                    END) AS `range_est`,
                    `programs`.`archived` AS `archived`
                FROM
                    ((((((((((`pledges`
                    LEFT JOIN `users` `Sponsor` ON ((`Sponsor`.`id` = `pledges`.`user_id`)))
                    LEFT JOIN `pledge_sponsors` `PledgeSponsor` ON ((`PledgeSponsor`.`id` = `pledges`.`pledge_sponsor_id`)))
                    JOIN `users` ON ((`users`.`id` = `pledges`.`participant_user_id`)))
                    LEFT JOIN `participants` ON ((`participants`.`user_id` = `pledges`.`participant_user_id`)))
                    JOIN `classrooms` ON (((`classrooms`.`id` = `participants`.`classroom_id`)
                        OR (`classrooms`.`teacher_id` = `pledges`.`participant_user_id`))))
                    JOIN `groups` ON ((`groups`.`id` = `classrooms`.`group_id`)))
                    JOIN `programs` ON ((`programs`.`id` = `groups`.`program_id`)))
                    LEFT JOIN `view_school` ON ((`view_school`.`id` = `programs`.`school_id`)))
                    JOIN `pledge_types` ON ((`pledge_types`.`id` = `pledges`.`pledge_type_id`)))
                    JOIN `pledge_statuses` ON ((`pledge_statuses`.`id` = `pledges`.`pledge_status_id`)))
                WHERE
                    (`pledges`.`deleted`
                        AND (NOT (`users`.`deleted`)))');



            DB::statement('DROP VIEW IF EXISTS `view_program_student_parts`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_student_parts` AS
                SELECT
                    `users`.`id` AS `id`,
                    `users`.`first_name` AS `first_name`,
                    `users`.`last_name` AS `last_name`,
                    `users`.`fr_code` AS `fr_code`,
                    `users`.`laps` AS `laps`,
                    `users`.`last_login` AS `last_login`,
                    IF(`users`.`registered`, 1, NULL) AS `login_status`,
                    `grades`.`name` AS `grade_name`,
                    `participants`.`classroom_id` AS `classroom_id`,
                    `classrooms`.`name` AS `class`,
                    `classrooms`.`grade_id` AS `grade_id`,
                    `classrooms`.`group_id` AS `group_id`,
                    `groups`.`program_id` AS `program_id`,
                    `groups`.`name` AS `group_name`,
                    `users_user_groups`.`group_id` AS `user_group_id`,
                    MAX(`users_notes`.`last_updated`) AS `note_date`
                FROM
                    ((((((`users`
                    JOIN `participants` ON ((`participants`.`user_id` = `users`.`id`)))
                    JOIN `users_user_groups` ON ((`users_user_groups`.`user_id` = `users`.`id`)))
                    LEFT JOIN `users_notes` ON ((`users_notes`.`user_id` = `users`.`id`)))
                    JOIN `classrooms` ON ((`classrooms`.`id` = `participants`.`classroom_id`)))
                    JOIN `groups` ON ((`groups`.`id` = `classrooms`.`group_id`)))
                    JOIN `grades` ON ((`classrooms`.`grade_id` = `grades`.`id`)))
                WHERE
                    ((NOT (`users`.`deleted`))
                        AND (`users`.`first_name` IS NOT NULL)
                        AND (`users`.`last_name` IS NOT NULL)
                        AND (`users_user_groups`.`group_id` = 3)
                        AND (`groups`.`program_id` = PROGRAM_ID()))
                GROUP BY `users`.`id`');




            DB::statement('DROP VIEW IF EXISTS `view_program_students`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_students` AS
                SELECT
                    `users`.`id` AS `id`,
                    `users`.`first_name` AS `first_name`,
                    `users`.`last_name` AS `last_name`,
                    `users`.`fr_code` AS `fr_code`,
                    `users`.`laps` AS `laps`,
                    `users`.`last_login` AS `last_login`,
                    IF(`users`.`registered`, 1, NULL) AS `login_status`,
                    `users`.`waiver_ts` AS `waiver_ts`,
                    `grades`.`name` AS `grade_name`,
                    `participants`.`classroom_id` AS `classroom_id`,
                    `classrooms`.`name` AS `class`,
                    `classrooms`.`grade_id` AS `grade_id`,
                    `classrooms`.`group_id` AS `group_id`,
                    `groups`.`program_id` AS `program_id`,
                    `groups`.`name` AS `group_name`,
                    `users_user_groups`.`group_id` AS `user_group_id`
                FROM
                    (((((`users`
                    JOIN `participants` ON ((`participants`.`user_id` = `users`.`id`)))
                    JOIN `classrooms` ON ((`classrooms`.`id` = `participants`.`classroom_id`)))
                    JOIN `groups` ON ((`groups`.`id` = `classrooms`.`group_id`)))
                    JOIN `grades` ON ((`classrooms`.`grade_id` = `grades`.`id`)))
                    JOIN `users_user_groups` ON ((`users_user_groups`.`user_id` = `participants`.`user_id`)))
                WHERE
                    ((NOT (`users`.`deleted`))
                        AND (`users`.`last_name` IS NOT NULL)
                        AND (`users_user_groups`.`group_id` IN (3 , 7)))');






            DB::statement('DROP VIEW IF EXISTS `view_program_teacher_parts`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_program_teacher_parts` AS
                SELECT
                    `users`.`id` AS `id`,
                    `users`.`first_name` AS `first_name`,
                    `users`.`last_name` AS `last_name`,
                    `users`.`fr_code` AS `fr_code`,
                    `users`.`laps` AS `laps`,
                    `users`.`last_login` AS `last_login`,
                    `grades`.`name` AS `grade_name`,
                    `participants`.`classroom_id` AS `classroom_id`,
                    `classrooms`.`name` AS `class`,
                    `classrooms`.`grade_id` AS `grade_id`,
                    `classrooms`.`group_id` AS `group_id`,
                    `groups`.`program_id` AS `program_id`,
                    `groups`.`name` AS `group_name`,
                    `users_user_groups`.`group_id` AS `user_group_id`
                FROM
                    (((((`users`
                    JOIN `participants` ON ((`participants`.`user_id` = `users`.`id`)))
                    JOIN `users_user_groups` ON ((`users_user_groups`.`user_id` = `users`.`id`)))
                    JOIN `classrooms` ON ((`classrooms`.`id` = `participants`.`classroom_id`)))
                    JOIN `groups` ON ((`groups`.`id` = `classrooms`.`group_id`)))
                    JOIN `grades` ON ((`classrooms`.`grade_id` = `grades`.`id`)))
                WHERE
                    ((NOT (`users`.`deleted`))
                        AND (`users`.`last_name` IS NOT NULL)
                        AND (`users_user_groups`.`group_id` = 7))');



            DB::statement('DROP VIEW IF EXISTS `view_student_payments`;');
            DB::statement('CREATE
                
                
                
            VIEW `view_student_payments` AS
                SELECT
                    `payments`.`id` AS `id`,
                    `payments`.`created_at` AS `created_at`,
                    `payments`.`first_name` AS `first_name`,
                    `payments`.`last_name` AS `last_name`,
                    CAST(`payments`.`created_at` AS DATE) AS `entered_date`,
                    CONCAT(`payments`.`last_name`,
                            \', \',
                            `payments`.`first_name`) AS `last_first_name`,
                    `payments`.`amount` AS `amount`,
                    `payments`.`note` AS `note`,
                    `payments`.`address` AS `address`,
                    `payments`.`phone` AS `phone`,
                    `payments`.`city` AS `city`,
                    `payments`.`state` AS `state`,
                    `payments`.`zip` AS `zip`,
                    `Split`.`student_id` AS `student_id`,
                    `Split`.`amount` AS `split_amount`,
                    IFNULL(`manual_payments`.`type`, \'CC\') AS `type`,
                    `manual_payments`.`check_number` AS `check_number`
                FROM
                    (((`payments`
                    LEFT JOIN `manual_payments` ON ((`manual_payments`.`payment_id` = `payments`.`id`)))
                    LEFT JOIN `online_payments` ON ((`online_payments`.`payment_id` = `payments`.`id`)))
                    JOIN `payments_students` `Split` ON ((`Split`.`payment_id` = `payments`.`id`)))
                WHERE
                    ((`payments`.`deleted` = 0)
                        AND (`Split`.`deleted` = 0))');


        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //no down
    }
}
