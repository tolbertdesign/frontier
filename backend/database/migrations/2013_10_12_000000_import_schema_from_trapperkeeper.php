<?php
// @codingStandardsIgnoreFile

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImportSchemaFromTrapperkeeper extends Migration
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
        if (in_array(env('APP_ENV'), ['local', 'dev', 'testing'])) {
            DB::statement('DROP TABLE IF EXISTS `ad_locations`;');

            DB::statement('CREATE TABLE `ad_locations` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `location` varchar(100) DEFAULT NULL,
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
            ');

            DB::statement('DROP TABLE IF EXISTS `braintree_customers`;');

            DB::statement('CREATE TABLE `braintree_customers` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(11) unsigned NOT NULL,
                `bt_customer_id` varchar(128) NOT NULL,
                `first_name` varchar(50) NOT NULL,
                `last_name` varchar(50) NOT NULL,
                `email` varchar(100) NOT NULL,
                `phone` varchar(20) DEFAULT NULL,
                `address` varchar(200) DEFAULT NULL,
                `city` varchar(50) DEFAULT NULL,
                `state` varchar(30) DEFAULT NULL,
                `zip` varchar(10) DEFAULT NULL,
                `country` char(2) DEFAULT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `bt_customer_id` (`bt_customer_id`),
                KEY `user_id` (`user_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `braintree_merchants`;');

            DB::statement("CREATE TABLE `braintree_merchants` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `first_name` varchar(64) NOT NULL,
                `last_name` varchar(64) NOT NULL,
                `email` varchar(64) NOT NULL,
                `point_person_phone` varchar(64) DEFAULT NULL,
                `dob` date NOT NULL,
                `point_person_address` varchar(128) NOT NULL,
                `point_person_city` varchar(64) NOT NULL,
                `point_person_state` varchar(16) NOT NULL,
                `point_person_zip` varchar(16) NOT NULL,
                `legal_name` varchar(255) NOT NULL,
                `dba` varchar(128) NOT NULL DEFAULT 'funrun.com',
                `tax_id` varchar(16) NOT NULL,
                `organization_address` varchar(128) NOT NULL,
                `organization_city` varchar(64) NOT NULL,
                `organization_state` varchar(16) NOT NULL,
                `organization_zip` varchar(16) NOT NULL,
                `account_number` varchar(128) NOT NULL,
                `routing_number` varchar(128) NOT NULL,
                `school_id` int(11) DEFAULT NULL,
                `status` varchar(32) DEFAULT NULL,
                `tos` tinyint(1) DEFAULT '0',
                `approval_status` varchar(32) DEFAULT NULL,
                `error_message` varchar(128) DEFAULT NULL,
                `errors` varchar(256) DEFAULT NULL,
                `braintree_merchant_id` varchar(128) DEFAULT NULL,
                `escrow_funds` tinyint(1) unsigned DEFAULT '1',
                PRIMARY KEY (`id`),
                KEY `fk_school_merchant` (`school_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
            ");

            DB::statement('DROP TABLE IF EXISTS `braintree_tokens`;');

            DB::statement('CREATE TABLE `braintree_tokens` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `bt_customer_id` int(11) unsigned NOT NULL,
                `bt_token` varchar(128) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `key_token_customer` (`bt_customer_id`,`bt_token`),
                KEY `bt_token` (`bt_token`),
                KEY `bt_customer_id` (`bt_customer_id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
            ');

            DB::statement('DROP TABLE IF EXISTS `cc_transaction_actions`;');

            DB::statement("CREATE TABLE `cc_transaction_actions` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `cc_transaction_id` int(11) unsigned NOT NULL,
            `status` varchar(128) DEFAULT NULL,
            `order_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `additional_info` varchar(256) DEFAULT NULL,
            `deleted` tinyint(1) unsigned DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `cc_trans_fk` (`cc_transaction_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `cc_transaction_pledges`;');

            DB::statement("CREATE TABLE `cc_transaction_pledges` (
            `cc_transaction_id` int(11) unsigned NOT NULL,
            `pledge_id` int(10) unsigned NOT NULL,
            `deleted` tinyint(1) unsigned DEFAULT '0',
            KEY `cc_transaction_id_index` (`cc_transaction_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `cc_transactions`;');

            DB::statement("CREATE TABLE `cc_transactions` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `order_id` varchar(64) DEFAULT NULL,
            `first_name` varchar(64) DEFAULT NULL,
            `last_name` varchar(64) DEFAULT NULL,
            `email` varchar(64) DEFAULT NULL,
            `phone` varchar(64) DEFAULT NULL,
            `amount` decimal(8,2) DEFAULT NULL,
            `merchant_id` varchar(64) NOT NULL,
            `deleted` tinyint(1) unsigned DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `order_id_index` (`order_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `classroom_shirts`;');

            DB::statement('CREATE TABLE `classroom_shirts` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `classroom_id` int(11) unsigned NOT NULL,
            `youth_s` mediumint(5) unsigned DEFAULT NULL,
            `youth_m` mediumint(5) unsigned DEFAULT NULL,
            `youth_l` mediumint(5) unsigned DEFAULT NULL,
            `adult_s` mediumint(5) unsigned DEFAULT NULL,
            `adult_m` mediumint(5) unsigned DEFAULT NULL,
            `adult_l` mediumint(5) unsigned DEFAULT NULL,
            `adult_xl` mediumint(5) unsigned DEFAULT NULL,
            `adult_2xl` mediumint(5) unsigned DEFAULT NULL,
            `adult_3xl` mediumint(5) unsigned DEFAULT NULL,
            `adult_4xl` mediumint(5) unsigned DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `classroom_id` (`classroom_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `classrooms`;');

            DB::statement("CREATE TABLE `classrooms` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `grade_id` int(2) NOT NULL,
            `name` varchar(50) NOT NULL DEFAULT '',
            `group_id` int(11) DEFAULT NULL,
            `teacher_id` int(11) DEFAULT NULL,
            `teacher_2_id` int(11) DEFAULT NULL,
            `teacher_3_id` int(11) DEFAULT NULL,
            `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `number_of_participants` int(11) DEFAULT NULL,
            `team_member_code` int(11) DEFAULT NULL,
            `team_leader_code` int(11) DEFAULT NULL,
            `pledge_meter` decimal(8,2) unsigned NOT NULL,
            `deleted` tinyint(1) DEFAULT '0',
            PRIMARY KEY (`id`),
            UNIQUE KEY `team_leader_code` (`team_leader_code`),
            UNIQUE KEY `team_member_code` (`team_member_code`),
            KEY `name_index` (`name`),
            KEY `group_index` (`group_id`),
            KEY `teacher_index` (`teacher_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `collection_reminder_history`;');

            DB::statement('CREATE TABLE `collection_reminder_history` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `program_id` int(11) unsigned NOT NULL,
            `user_id` int(11) unsigned NOT NULL,
            `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_collection_reminder_history_program_id` (`program_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `custom_program_alerts`;');

            DB::statement("CREATE TABLE `custom_program_alerts` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `text` text,
            `start` datetime DEFAULT NULL,
            `end` datetime DEFAULT NULL,
            `program_id` int(11) unsigned NOT NULL,
            `active` int(1) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `program_fk` (`program_id`),
            KEY `start` (`start`),
            KEY `end` (`end`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `email_notifications`;');

            DB::statement("CREATE TABLE `email_notifications` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(11) unsigned NOT NULL,
            `email` varchar(100) NOT NULL,
            `notification_type` varchar(100) NOT NULL,
            `notification_value` varchar(100) DEFAULT NULL,
            `notification_sent` int(11) unsigned NOT NULL,
            `program_id` int(11) unsigned DEFAULT NULL,
            `recipients` int(11) DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`,`notification_type`),
            KEY `email` (`email`,`notification_type`),
            KEY `notification_value` (`notification_value`),
            KEY `program_notification_fk` (`program_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `entered_locations`;');

            DB::statement("CREATE TABLE `entered_locations` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `field_aliases`;');

            DB::statement('CREATE TABLE `field_aliases` (
            `alias` varchar(20) NOT NULL,
            `field` varchar(20) NOT NULL,
            PRIMARY KEY (`alias`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `grade_aliases`;');

            DB::statement('CREATE TABLE `grade_aliases` (
            `grade_id` int(11) NOT NULL,
            `alias` varchar(20) NOT NULL,
            PRIMARY KEY (`alias`),
            KEY `fk_to_grade_id` (`grade_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `grades`;');

            DB::statement('CREATE TABLE `grades` (
            `id` int(11) NOT NULL,
            `name` varchar(64) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `group_levels`;');

            DB::statement("CREATE TABLE `group_levels` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `groups`;');

            DB::statement("CREATE TABLE `groups` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `salesforce_id` varchar(50) NOT NULL DEFAULT '',
            `name` varchar(50) NOT NULL DEFAULT '',
            `classroom_goal` text,
            `projected_students` int(11) DEFAULT NULL,
            `program_id` int(11) DEFAULT NULL,
            `point_person_id` int(11) DEFAULT NULL,
            `projected_raised_per_student` decimal(8,2) DEFAULT NULL,
            `projected_raised` decimal(10,2) DEFAULT NULL,
            `preprogram_students` int(11) DEFAULT NULL,
            `participating_students` int(11) DEFAULT NULL,
            `preprogram_homerooms` int(11) DEFAULT NULL,
            `preprogram_faculty` int(11) DEFAULT NULL,
            `lap_average` decimal(5,2) DEFAULT NULL,
            `actual_students` int(11) DEFAULT NULL,
            `actual_students_override` tinyint(1) DEFAULT '0',
            `level` varchar(50) DEFAULT NULL,
            `pep_rally` datetime DEFAULT NULL,
            `fun_run` datetime DEFAULT NULL,
            `due_date` datetime DEFAULT NULL,
            `populated` tinyint(1) DEFAULT NULL,
            `group_level_id` int(11) DEFAULT NULL,
            `sf_program_id` varchar(50) DEFAULT NULL,
            `sf_point_person_id` varchar(50) DEFAULT NULL,
            `sf_opportunity_id` varchar(50) NOT NULL,
            `deleted` tinyint(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            UNIQUE KEY `salesforce_id` (`salesforce_id`),
            KEY `program_index` (`program_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `hero_video_jobs`;');

            DB::statement('CREATE TABLE `hero_video_jobs` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `job_id` int(10) unsigned NOT NULL,
            `user_id` int(10) unsigned NOT NULL,
            `status` varchar(50) DEFAULT NULL,
            `submitted_on` int(10) unsigned NOT NULL,
            `completed_on` int(10) unsigned NOT NULL,
            `video_url` varchar(500) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `job_id` (`job_id`),
            KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `log_event_types`;');

            DB::statement('CREATE TABLE `log_event_types` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100) DEFAULT NULL,
            `description` varchar(500) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `login_attempts`;');

            DB::statement('CREATE TABLE `login_attempts` (
            `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `ip_address` varbinary(16) NOT NULL,
            `login` varchar(100) NOT NULL,
            `time` int(11) unsigned DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `logs`;');

            DB::statement('CREATE TABLE `logs` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `log_event_type_id` int(11) DEFAULT NULL,
            `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `description` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `manual_payments`;');

            DB::statement("CREATE TABLE `manual_payments` (
            `payment_id` int(10) unsigned NOT NULL,
            `entered_by` int(10) unsigned DEFAULT NULL,
            `type` enum('cash','check','cmg') NOT NULL,
            `check_number` varchar(20) DEFAULT NULL,
            `classroom_id` int(10) unsigned NOT NULL,
            `deleted` tinyint(1) unsigned DEFAULT '0',
            PRIMARY KEY (`payment_id`),
            KEY `payment_to_classroom` (`classroom_id`),
            KEY `fk_entered_by_user` (`entered_by`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `meta`;');

            DB::statement('CREATE TABLE `meta` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            `value` varchar(500) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `microsite_color_themes`;');

            DB::statement('CREATE TABLE `microsite_color_themes` (
            `id` varchar(7) NOT NULL,
            `theme_name` varchar(50) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `microsite_pics`;');

            DB::statement('CREATE TABLE `microsite_pics` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `image` varchar(255) DEFAULT NULL,
            `description` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `microsite_videos`;');

            DB::statement('CREATE TABLE `microsite_videos` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `description` varchar(100) DEFAULT NULL,
            `hash` varchar(100) DEFAULT NULL,
            `url` varchar(255) DEFAULT NULL,
            `original_url` varchar(255) DEFAULT NULL,
            `source` varchar(255) DEFAULT NULL,
            `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `microsites`;');

            DB::statement("CREATE TABLE `microsites` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `program_id` int(11) unsigned DEFAULT NULL,
            `intro_vid_override` varchar(50) DEFAULT '',
            `video_1` varchar(50) DEFAULT '',
            `video_2` varchar(50) DEFAULT '',
            `video_3` varchar(50) DEFAULT '',
            `video_4` varchar(50) DEFAULT '1538',
            `video_5` varchar(50) DEFAULT '55',
            `slug` varchar(100) DEFAULT NULL,
            `pic_1` int(11) DEFAULT NULL,
            `pic_2` int(11) DEFAULT NULL,
            `pic_3` int(11) DEFAULT NULL,
            `parents_invited` tinyint(1) DEFAULT '0',
            `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `hide_character_videos` tinyint(1) DEFAULT '0',
            `overview_text_override` text,
            `school_image_name` varchar(255) DEFAULT NULL,
            `color_theme_id` varchar(7) DEFAULT NULL,
            `funds_raised_for` varchar(300) DEFAULT NULL,
            `get_pledges_vid_override` int(11) DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `program_fk` (`program_id`),
            KEY `color_theme_fk` (`color_theme_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `migration_logs`;');

            DB::statement('CREATE TABLE `migration_logs` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `migration` varchar(512) NOT NULL,
            `name` varchar(512) NOT NULL,
            `batch` int(11) NOT NULL,
            `date_time` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `name` (`name`),
            KEY `migration` (`migration`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `online_payments`;');

            DB::statement("CREATE TABLE `online_payments` (
            `payment_id` int(10) unsigned NOT NULL,
            `order_id` varchar(64) DEFAULT NULL,
            `sponsor_convenience_fee` decimal(8,2) unsigned NOT NULL,
            `school_processing_fee` decimal(8,2) unsigned DEFAULT '0.00',
            `optional_sponsor_fee` decimal(8,2) unsigned DEFAULT '0.00',
            `deleted` tinyint(1) unsigned DEFAULT '0',
            PRIMARY KEY (`payment_id`),
            UNIQUE KEY `order_id` (`order_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `online_pending_payment_pledges`;');

            DB::statement("CREATE TABLE `online_pending_payment_pledges` (
            `online_pending_payments_id` int(11) unsigned NOT NULL,
            `pledge_id` int(11) unsigned NOT NULL,
            `deleted` tinyint(1) unsigned DEFAULT '0',
            KEY `online_pending_payments_id` (`online_pending_payments_id`),
            KEY `pledge_id` (`pledge_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `online_pending_payment_statuses`;');

            DB::statement('CREATE TABLE `online_pending_payment_statuses` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `online_pending_payments`;');

            DB::statement("CREATE TABLE `online_pending_payments` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `order_id` varchar(64) NOT NULL,
            `sponsor_convenience_fee` decimal(8,2) unsigned NOT NULL,
            `school_processing_fee` decimal(8,2) unsigned DEFAULT '0.00',
            `bt_customer_id` int(11) unsigned NOT NULL,
            `bt_token_id` int(11) unsigned NOT NULL,
            `online_pending_payment_status_id` int(11) NOT NULL DEFAULT '1',
            `optional_sponsor_fee` decimal(8,2) unsigned DEFAULT '0.00',
            `deleted` tinyint(1) unsigned DEFAULT '0',
            PRIMARY KEY (`id`),
            UNIQUE KEY `order_id` (`order_id`),
            KEY `bt_customer_token_id` (`bt_customer_id`,`bt_token_id`),
            KEY `online_pending_payment_status_id` (`online_pending_payment_status_id`),
            KEY `fk_bt_token_id` (`bt_token_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `organization_administrators`;');

            DB::statement("CREATE TABLE `organization_administrators` (
            `user_id` int(10) unsigned NOT NULL,
            `school_id` int(11) NOT NULL,
            `receive_task_emails` tinyint(1) NOT NULL DEFAULT '1',
            KEY `org_admin_user` (`user_id`),
            KEY `org_admin_school` (`school_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `participants`;');

            DB::statement("CREATE TABLE `participants` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `classroom_id` int(11) DEFAULT NULL,
            `user_id` int(11) unsigned DEFAULT NULL,
            `family_pledging_enabled` tinyint(1) DEFAULT NULL,
            `allow_pay_later_override` tinyint(1) DEFAULT '0',
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_class_per_user` (`user_id`,`classroom_id`),
            KEY `user_id_index` (`user_id`),
            KEY `classroom_index` (`classroom_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `payment_notify`;');

            DB::statement("CREATE TABLE `payment_notify` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(10) unsigned NOT NULL COMMENT 'Recipient of notice',
            `program_id` int(10) unsigned NOT NULL,
            `participant_id` int(10) unsigned NOT NULL DEFAULT '0',
            `ts_notified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `notified_program_id_fk` (`program_id`),
            KEY `notified_participant_id_fk` (`participant_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `payment_student_backup`;');

            DB::statement('CREATE TABLE `payment_student_backup` (
            `payment_id` int(10) unsigned NOT NULL,
            `student_id` int(10) unsigned NOT NULL,
            `amount` decimal(8,2) unsigned NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `payments`;');

            DB::statement("CREATE TABLE `payments` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `amount` decimal(8,2) unsigned NOT NULL,
            `note` varchar(400) DEFAULT NULL,
            `first_name` varchar(50) DEFAULT NULL,
            `last_name` varchar(50) DEFAULT NULL,
            `address` varchar(200) DEFAULT NULL,
            `phone` varchar(20) DEFAULT NULL,
            `city` varchar(50) DEFAULT NULL,
            `state` varchar(30) DEFAULT NULL,
            `zip` varchar(10) DEFAULT NULL,
            `receipt` tinyint(1) unsigned DEFAULT NULL,
            `entered_by_name` varchar(100) DEFAULT NULL,
            `deleted` tinyint(1) unsigned DEFAULT '0',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `payments_students`;');

            DB::statement("CREATE TABLE `payments_students` (
            `payment_id` int(10) unsigned NOT NULL,
            `student_id` int(10) unsigned NOT NULL,
            `amount` decimal(8,2) unsigned NOT NULL,
            `add_to_envelope` tinyint(1) DEFAULT '1',
            `deleted` tinyint(1) unsigned DEFAULT '0',
            PRIMARY KEY (`payment_id`,`student_id`),
            KEY `student_index` (`student_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `pledge_entered_location`;');

            DB::statement('CREATE TABLE `pledge_entered_location` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `pledge_id` int(11) unsigned NOT NULL,
            `entered_location_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            KEY `fk_entered_pledges_pledge_id_to_pledge_id` (`pledge_id`),
            KEY `fk_entered_locations_id_to_entered_locations_id` (`entered_location_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `pledge_notes`;');

            DB::statement('CREATE TABLE `pledge_notes` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `content` text NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `pledge_id` int(11) NOT NULL,
            `entered_by_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;');

            DB::statement('DROP TABLE IF EXISTS `pledge_periods`;');

            DB::statement('CREATE TABLE `pledge_periods` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `delivery_ts` datetime NOT NULL,
            `ordinal` int(11) NOT NULL,
            `program_id` int(11) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `ordinal_index` (`ordinal`),
            KEY `program_index` (`program_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `pledge_referrers`;');

            DB::statement('CREATE TABLE `pledge_referrers` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `pledge_id` int(11) unsigned NOT NULL,
            `referrer_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `pledge_id` (`pledge_id`),
            KEY `fk_referrer_id_for_referrers` (`referrer_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `pledge_sponsors`;');

            DB::statement('CREATE TABLE `pledge_sponsors` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `first_name` varchar(50) DEFAULT NULL,
            `last_name` varchar(50) DEFAULT NULL,
            `phone` varchar(20) DEFAULT NULL,
            `email` varchar(100) DEFAULT NULL,
            `address` varchar(200) DEFAULT NULL,
            `city` varchar(50) DEFAULT NULL,
            `state` varchar(30) DEFAULT NULL,
            `zip` varchar(10) DEFAULT NULL,
            `country` varchar(50) DEFAULT NULL,
            `ts_updated` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `ts_created` timestamp DEFAULT CURRENT_TIMESTAMP,
            -- `ts_created` timestamp DEFAULT "0000-00-00 00:00:00",
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `pledge_statuses`;');

            DB::statement('CREATE TABLE `pledge_statuses` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `pledge_substatuses`;');

            DB::statement('CREATE TABLE `pledge_substatuses` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `parent_id` int(11) DEFAULT NULL,
            `name` varchar(50) DEFAULT NULL,
            `description` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `pledge_types`;');

            DB::statement('CREATE TABLE `pledge_types` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            `long_name` varchar(50) DEFAULT NULL,
            `multiplier_low` int(11) DEFAULT NULL,
            `multiplier_high` int(11) DEFAULT NULL,
            `multiplier_average` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `name_index` (`name`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `pledges`;');

            DB::statement("CREATE TABLE `pledges` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `participant_user_id` int(11) unsigned DEFAULT NULL,
            `program_id` int(11) unsigned NOT NULL,
            `family_pledge_id` varchar(20) DEFAULT NULL,
            `group_id` int(11) unsigned NOT NULL,
            `user_id` int(11) unsigned DEFAULT NULL,
            `sponsor_type_id` int(11) unsigned DEFAULT NULL,
            `sponsor_type_other` varchar(50) DEFAULT NULL,
            `pledge_type_id` int(11) unsigned NOT NULL,
            `business_website` varchar(255) DEFAULT '',
            `business_name` varchar(50) DEFAULT NULL,
            `display_business` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `anon` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `comment` varchar(140) NULL,
            `show_comment` tinyint(3) NOT NULL DEFAULT 1,
            `anon_first_name` varchar(50) DEFAULT NULL,
            `anon_last_name` varchar(50) DEFAULT NULL,
            `amount` decimal(10,2) unsigned NOT NULL,
            `ip_address` varchar(45) NOT NULL,
            `pledge_status_id` int(11) unsigned NOT NULL,
            `pledge_substatus_id` int(10) unsigned DEFAULT NULL,
            `ts_entered` datetime NOT NULL,
            `ts_completed` datetime DEFAULT NULL,
            `entered_by_user_id` int(10) unsigned DEFAULT NULL,
            `unflagged_by` int(10) unsigned DEFAULT NULL,
            `deleted` tinyint(4) NOT NULL,
            `protected` tinyint(4) NOT NULL,
            `last_modified_by_id` int(10) unsigned DEFAULT NULL,
            `ts_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `ts_confirmed` datetime DEFAULT NULL,
            `ts_deleted` datetime DEFAULT NULL,
            `pledge_sponsor_id` int(11) unsigned DEFAULT NULL,
            `payment_id` int(10) unsigned DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `program_id` (`program_id`),
            KEY `user_id` (`user_id`),
            KEY `pledge_type_id` (`pledge_type_id`),
            KEY `pledge_status_id` (`pledge_status_id`),
            KEY `group_id` (`group_id`),
            KEY `sponsor_type_id` (`sponsor_type_id`),
            KEY `fk_pledge_sponsor` (`pledge_sponsor_id`),
            KEY `parent_payment` (`payment_id`),
            KEY `fk_pledge_to_pledge_substatus` (`pledge_substatus_id`),
            KEY `fk_pledge_to_unflagged_by_user` (`unflagged_by`),
            KEY `last_modified_by_id` (`last_modified_by_id`),
            KEY `entered_by_user_id` (`entered_by_user_id`),
            KEY `deleted_index` (`deleted`),
            KEY `participant_user_id` (`participant_user_id`),
            KEY `idx_pledges_family_pledge_id` (`family_pledge_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `potential_sponsors`;');

            DB::statement("CREATE TABLE `potential_sponsors` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `first_name` varchar(50) DEFAULT NULL,
            `last_name` varchar(50) DEFAULT NULL,
            `participant_user_id` int(11) unsigned NOT NULL,
            `sponsor_user_id` int(11) unsigned DEFAULT '0',
            `deleted` tinyint(1) unsigned DEFAULT '0',
            `enrollment` tinyint(1) unsigned DEFAULT '0',
            `day_before_run` tinyint(1) unsigned DEFAULT '0',
            `day_after_run` tinyint(1) unsigned DEFAULT '0',
            `sender_user_id` int(11) NOT NULL DEFAULT '0',
            `opt_out` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `email_index` (`email`),
            KEY `participant_user_id_index` (`participant_user_id`),
            KEY `sponsor_user_id_index` (`sponsor_user_id`),
            KEY `deleted_index` (`deleted`),
            KEY `enrollment_index` (`enrollment`),
            KEY `day_before_run_index` (`day_before_run`),
            KEY `day_after_run_index` (`day_after_run`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `prizes`;');

            DB::statement('CREATE TABLE `prizes` (
            `id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `name` char(128) NOT NULL,
            `inventory_code` varchar(128) NOT NULL,
            `picture` varchar(128) DEFAULT NULL,
            `video` varchar(128) DEFAULT NULL,
            `salesforce_id` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `salesforce_id` (`salesforce_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;');

            DB::statement('DROP TABLE IF EXISTS `prizes_bound`;');

            DB::statement('CREATE TABLE `prizes_bound` (
            `id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `prize_id` mediumint(9) NOT NULL,
            `display_name` varchar(128) DEFAULT NULL,
            `display_amount` decimal(6,2) DEFAULT NULL,
            `actual_amount` decimal(6,2) DEFAULT NULL,
            `group_id` mediumint(9) NOT NULL,
            `pledge_period_ordinal` mediumint(9) DEFAULT NULL,
            `quantity` mediumint(6) unsigned DEFAULT NULL,
            `activity_reward` int(10) unsigned DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `prize_index` (`prize_id`),
            KEY `group_index` (`group_id`),
            KEY `idx_activity_reward` (`activity_reward`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `prizes_bound_student`;');

            DB::statement("CREATE TABLE `prizes_bound_student` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `student_id` int(11) NOT NULL,
            `prize_id` int(11) NOT NULL,
            `status` varchar(64) NOT NULL DEFAULT 'unassigned',
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `student_index` (`student_id`),
            KEY `prize_index` (`prize_id`),
            KEY `status_index` (`status`),
            KEY `time_index` (`updated_at`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `prizes_bound_template`;');

            DB::statement('CREATE TABLE `prizes_bound_template` (
            `id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `prize_id` mediumint(9) NOT NULL,
            `prize_list_id` mediumint(9) NOT NULL,
            `display_name` varchar(128) DEFAULT NULL,
            `display_amount` decimal(6,2) DEFAULT NULL,
            `actual_amount` decimal(6,2) DEFAULT NULL,
            `pledge_period_ordinal` mediumint(9) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `prize_fk` (`prize_id`),
            KEY `prizes_list_fk` (`prize_list_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `prizes_list`;');

            DB::statement("CREATE TABLE `prizes_list` (
            `id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `display_name` varchar(128) DEFAULT NULL,
            `deleted` tinyint(1) DEFAULT '0',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `program_pledge_settings`;');

            DB::statement("CREATE TABLE `program_pledge_settings` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `program_id` int(11) unsigned NOT NULL,
            `flag_high_donation` mediumint(6) NOT NULL,
            `flag_high_cumulative_per_period` mediumint(6) NOT NULL,
            `weekend_challenge_amount` tinyint(2) unsigned DEFAULT '2',
            `flag_high_quantity_per_period` smallint(3) NOT NULL,
            `flat_donate_only` tinyint(1) unsigned NOT NULL,
            `ppu_donations_only` tinyint(1) DEFAULT NULL,
            `flag_payment_scheduled_high_value` mediumint(6) unsigned DEFAULT '150',
            `recommended_pledge_amounts` text NOT NULL,
            `family_pledging_enabled` tinyint(1) DEFAULT '1',
            `minimize_flat_donation` tinyint(1) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `fk_program_pledge_settings_to_program` (`program_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `program_sponsor_ad_locations`;');

            DB::statement("CREATE TABLE `program_sponsor_ad_locations` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `program_sponsor_ad_id` int(10) unsigned NOT NULL,
            `ad_location_id` int(10) unsigned NOT NULL,
            `clicks` int(10) unsigned DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `program_sponsor_ad_id` (`program_sponsor_ad_id`),
            KEY `ad_location_id` (`ad_location_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `program_sponsor_ads`;');

            DB::statement('CREATE TABLE `program_sponsor_ads` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `program_sponsor_id` int(10) unsigned NOT NULL,
            `ad_text` varchar(2000) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `program_sponsor_id` (`program_sponsor_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `program_sponsors`;');

            DB::statement('CREATE TABLE `program_sponsors` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `program_todos`;');

            DB::statement('CREATE TABLE `program_todos` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `program_id` int(11) NOT NULL,
            `todo_label` varchar(32) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `program_id` (`program_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `programs`;');

            DB::statement("CREATE TABLE `programs` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) DEFAULT NULL,
            `school_id` int(11) DEFAULT NULL,
            `preprogram_students_total` int(11) DEFAULT NULL,
            `preprogram_homerooms` int(11) DEFAULT NULL,
            `projected_students` int(11) DEFAULT NULL,
            `projected_raised` int(11) DEFAULT NULL,
            `projected_raised_per_student` int(11) DEFAULT NULL,
            `pep_rally` datetime DEFAULT NULL,
            `fun_run` datetime DEFAULT NULL,
            `due_date` datetime DEFAULT NULL,
            `teacher_party` datetime DEFAULT NULL,
            `preprogram` datetime DEFAULT NULL,
            `preprogram_fr` decimal(5,2) DEFAULT NULL,
            `parent_membership` decimal(5,2) DEFAULT NULL,
            `teacher_party_location` varchar(300) DEFAULT NULL,
            `preprogram_scheduled` tinyint(1) DEFAULT NULL,
            `semester` varchar(30) DEFAULT NULL,
            `projected_revenue` int(11) DEFAULT NULL,
            `school_contact_group` varchar(30) DEFAULT NULL,
            `pledged` int(11) DEFAULT NULL,
            `actual_students` int(11) DEFAULT NULL,
            `participating_students` int(11) DEFAULT NULL,
            `payee` varchar(255) DEFAULT NULL,
            `deleted` tinyint(1) DEFAULT '0',
            `team_id` int(11) DEFAULT NULL,
            `owner_id` int(11) DEFAULT NULL,
            `sf_opportunity_id` varchar(50) DEFAULT NULL,
            `salesforce_id` varchar(50) DEFAULT NULL,
            `salesforce_team_id` varchar(50) DEFAULT NULL,
            `sf_school_id` varchar(50) DEFAULT NULL,
            `sf_owner_id` varchar(50) DEFAULT NULL,
            `collection_type` enum('basic','donor_base') NOT NULL DEFAULT 'basic',
            `pledging_start` datetime DEFAULT NULL,
            `collection_refer_key` char(8) NOT NULL DEFAULT '',
            `sponsor_convenience_fee` decimal(8,2) unsigned DEFAULT '2.00',
            `optional_sponsor_fee` decimal(8,2) unsigned DEFAULT '0.00',
            `school_processing_fee` decimal(8,2) unsigned DEFAULT '0.00',
            `online_payment_enabled` tinyint(1) DEFAULT '0',
            `hold_online_payments` tinyint(1) DEFAULT NULL,
            `daily_pledge_target` int(11) DEFAULT NULL,
            `pledge_target` int(11) DEFAULT NULL,
            `total_raised_goal` mediumint(7) unsigned DEFAULT NULL,
            `client_percent` tinyint(3) unsigned DEFAULT NULL,
            `client_goal` mediumint(7) unsigned DEFAULT NULL,
            `archived` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `open_help` smallint(4) NOT NULL DEFAULT '0',
            `registration_code` varchar(50) DEFAULT NULL,
            `event_name` varchar(255) DEFAULT NULL,
            `parent_email_prompts` tinyint(1) unsigned DEFAULT '1',
            `facebook_share_prize` tinyint(1) unsigned DEFAULT '0',
            `restrict_access_prize_reports` tinyint(1) DEFAULT '0',
            `has_delivered_top_prizes` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `online_payment_required` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `filter_merchant_report_by_school` tinyint(1) unsigned DEFAULT '0',
            `unit_id` int(10) unsigned NOT NULL DEFAULT '1',
            `has_delivered_teacher_prizes` tinyint(1) unsigned NOT NULL DEFAULT '0',
            `promote_pay_online` tinyint(1) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_collect_refer_key` (`collection_refer_key`),
            UNIQUE KEY `salesforce_id` (`salesforce_id`),
            UNIQUE KEY `registration_code` (`registration_code`),
            KEY `mascot` (`name`,`payee`),
            KEY `semester` (`semester`),
            KEY `owner_id` (`owner_id`),
            KEY `archived_index` (`archived`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `programs_program_sponsors`;');

            DB::statement('CREATE TABLE `programs_program_sponsors` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `program_id` int(10) unsigned NOT NULL,
            `program_sponsor_id` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            KEY `program_id` (`program_id`),
            KEY `program_sponsor_id` (`program_sponsor_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `referrers`;');

            DB::statement('CREATE TABLE `referrers` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            `source` varchar(50) DEFAULT NULL,
            `medium` varchar(50) DEFAULT NULL,
            `content` varchar(50) DEFAULT NULL,
            `campaign` varchar(50) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `s3_reports`;');

            DB::statement('CREATE TABLE `s3_reports` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `program_id` varchar(35) NOT NULL,
            `type` varchar(64) NOT NULL,
            `filename` varchar(128) NOT NULL,
            `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `school_escrow_held_transactions`;');

            DB::statement("CREATE TABLE `school_escrow_held_transactions` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `transaction_id` varchar(32) NOT NULL,
            `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `success` tinyint(1) unsigned DEFAULT '0',
            `braintree_response` blob,
            PRIMARY KEY (`id`),
            KEY `idx_school_escrow_held_transactions_transaction_id` (`transaction_id`),
            KEY `idx_school_escrow_held_transactions_success` (`success`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `school_escrow_transactions`;');

            DB::statement('CREATE TABLE `school_escrow_transactions` (
            `transaction_id` varchar(32) NOT NULL,
            `school_id` int(11) NOT NULL,
            PRIMARY KEY (`transaction_id`),
            KEY `school_fk` (`school_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `schools`;');

            DB::statement("CREATE TABLE `schools` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) DEFAULT NULL,
            `type` varchar(20) DEFAULT NULL,
            `address` varchar(100) DEFAULT NULL,
            `city` varchar(50) DEFAULT NULL,
            `state` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
            `zip` varchar(20) DEFAULT NULL,
            `country` varchar(50) DEFAULT 'US',
            `charter` varchar(10) DEFAULT NULL,
            `school_wide_title_1` varchar(10) DEFAULT NULL,
            `urban_locale` varchar(10) DEFAULT NULL,
            `county` varchar(50) DEFAULT NULL,
            `latitude` decimal(9,2) DEFAULT NULL,
            `longitude` decimal(9,2) DEFAULT NULL,
            `category` varchar(50) DEFAULT NULL,
            `level` varchar(50) DEFAULT NULL,
            `metro_area` varchar(50) DEFAULT NULL,
            `deleted` tinyint(1) DEFAULT '0',
            `sf_updated_date` datetime DEFAULT NULL,
            `sf_created_date` datetime DEFAULT NULL,
            `salesforce_id` varchar(50) DEFAULT NULL,
            `abbreviation` varchar(10) DEFAULT NULL,
            `timezone` varchar(32) DEFAULT 'America/New_York',
            `merchant_type` varchar(64) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `salesforce_id` (`salesforce_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `sessions`;');

            DB::statement("CREATE TABLE `sessions` (
            `session_id` varchar(40) NOT NULL DEFAULT '0',
            `ip_address` varchar(45) NOT NULL DEFAULT '0',
            `user_agent` varchar(120) NOT NULL,
            `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
            `user_data` text NOT NULL,
            PRIMARY KEY (`session_id`),
            KEY `last_activity_idx` (`last_activity`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `special_urls`;');

            DB::statement('CREATE TABLE `special_urls` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(11) DEFAULT NULL,
            `referrer_id` int(11) DEFAULT NULL,
            `slug` varchar(40) DEFAULT NULL,
            `short_key` char(8) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `slug_2` (`slug`),
            UNIQUE KEY `short_key` (`short_key`),
            KEY `slug` (`slug`),
            KEY `fk_special_url_to_user` (`user_id`),
            KEY `fk_ref_id_to_referrer` (`referrer_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `sponsor_types`;');

            DB::statement('CREATE TABLE `sponsor_types` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `sponsor_type` varchar(50) NOT NULL,
            `description` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `student_imports`;');

            DB::statement("CREATE TABLE `student_imports` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `file_path` varchar(100) NOT NULL DEFAULT '',
            `import_data` mediumtext,
            `created_by` int(11) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `group_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `students_parents`;');

            DB::statement('CREATE TABLE `students_parents` (
            `student_id` int(11) unsigned NOT NULL,
            `parent_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`student_id`,`parent_id`),
            KEY `parent_index` (`parent_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `system_alert_locations`;');

            DB::statement('CREATE TABLE `system_alert_locations` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `system_alert_id` int(11) unsigned NOT NULL,
            `uri` varchar(256) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `system_alerts`;');

            DB::statement('CREATE TABLE `system_alerts` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `alert_message` varchar(500) NOT NULL,
            `alert_name` varchar(64) NOT NULL,
            `alert_color` varchar(7) DEFAULT NULL,
            `alert_enabled` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `alert_name_index` (`alert_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `usa_zip`;');

            DB::statement('CREATE TABLE `usa_zip` (
            `zipcode` mediumint(5) unsigned zerofill NOT NULL,
            `cityname` varchar(64) NOT NULL,
            `stateabbr` char(2) NOT NULL,
            `latitude` float NOT NULL,
            `longitude` float NOT NULL,
            `timezone` varchar(32) DEFAULT NULL,
            `dst` tinyint(1) NOT NULL,
            PRIMARY KEY (`zipcode`),
            KEY `stateabbr` (`stateabbr`),
            KEY `cityname` (`cityname`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_activities`;');

            DB::statement('CREATE TABLE `user_activities` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(35) NOT NULL,
            `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_activity_history`;');

            DB::statement('CREATE TABLE `user_activity_history` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `activity_id` int(11) unsigned NOT NULL,
            `user_id` int(11) unsigned NOT NULL,
            `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `idx_activity_id` (`activity_id`),
            KEY `idx_user_id` (`user_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_email_opt_out`;');

            DB::statement('CREATE TABLE `user_email_opt_out` (
            `email` varchar(255) NOT NULL,
            `user_email_type_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`email`,`user_email_type_id`),
            KEY `email_index` (`email`),
            KEY `user_email_type_id_index` (`user_email_type_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_email_types`;');

            DB::statement('CREATE TABLE `user_email_types` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_flagging_modes`;');

            DB::statement('CREATE TABLE `user_flagging_modes` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            `description` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_groups`;');

            DB::statement("CREATE TABLE `user_groups` (
            `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(20) NOT NULL,
            `description` varchar(100) DEFAULT '',
            `salesforce_id` varchar(50) DEFAULT NULL,
            `type` varchar(20) DEFAULT NULL,
            `deleted` tinyint(1) DEFAULT '0',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `user_new_fr_code`;');

            DB::statement('CREATE TABLE `user_new_fr_code` (
            `id` int(11) unsigned NOT NULL,
            `fr_code` varchar(20) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_profiles`;');

            DB::statement("CREATE TABLE `user_profiles` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(11) unsigned NOT NULL,
            `pledge_page_text` text,
            `video_url` varchar(255) DEFAULT NULL,
            `image_name` varchar(255) DEFAULT NULL,
            `pledge_goal` decimal(10,2) unsigned DEFAULT NULL,
            `created` datetime NOT NULL,
            `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted` tinyint(4) NOT NULL DEFAULT '0',
            `video_url_orig` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_id` (`user_id`),
            KEY `video_url_index` (`video_url`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `user_task_list_tasks`;');

            DB::statement("CREATE TABLE `user_task_list_tasks` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_task_list_id` int(11) unsigned NOT NULL,
            `user_task_template_id` int(11) unsigned NOT NULL,
            `event` varchar(25) NOT NULL,
            `event_offset` int(2) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `idx_user_task_list_tasks_user_task_list_id` (`user_task_list_id`),
            KEY `idx_user_task_list_tasks_user_task_template_id` (`user_task_template_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `user_task_lists`;');

            DB::statement('CREATE TABLE `user_task_lists` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(75) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_task_templates`;');

            DB::statement('CREATE TABLE `user_task_templates` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(1000) NOT NULL,
            `label` varchar(50) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `user_tasks`;');

            DB::statement("CREATE TABLE `user_tasks` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `program_id` int(11) unsigned DEFAULT NULL,
            `task_template_id` int(11) unsigned DEFAULT NULL,
            `assigned_to_user_id` int(11) unsigned DEFAULT NULL,
            `type` varchar(15) DEFAULT 'Program',
            `title` varchar(1000) NOT NULL,
            `label` varchar(50) DEFAULT NULL,
            `due_date` timestamp NULL DEFAULT NULL,
            `completed_on_date` timestamp NULL DEFAULT NULL,
            `completed_by_user_id` int(11) unsigned DEFAULT NULL,
            `created_by_user_id` int(11) unsigned NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_user_tasks_program_id` (`program_id`),
            KEY `idx_user_tasks_completed_by_user_id` (`completed_by_user_id`),
            KEY `idx_user_tasks_created_by_user_id` (`created_by_user_id`),
            KEY `idx_user_tasks_assigned_to_user_id` (`assigned_to_user_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");

            DB::statement('DROP TABLE IF EXISTS `users`;');

            DB::statement("CREATE TABLE `users` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `ip_address` varchar(16) NOT NULL DEFAULT '',
            `username` varchar(100) NOT NULL,
            `password` varchar(80) NOT NULL,
            `salt` varchar(40) DEFAULT NULL,
            `email` varchar(100) DEFAULT NULL,
            `activation_code` varchar(40) DEFAULT NULL,
            `forgotten_password_code` varchar(40) DEFAULT NULL,
            `forgotten_password_time` int(11) unsigned DEFAULT NULL,
            `remember_code` varchar(40) DEFAULT NULL,
            `created_on` int(11) unsigned NOT NULL,
            `last_login` int(11) unsigned DEFAULT NULL,
            `active` tinyint(1) DEFAULT NULL,
            `first_name` varchar(50) DEFAULT NULL,
            `last_name` varchar(50) DEFAULT NULL,
            `phone` varchar(20) DEFAULT NULL,
            `fr_code` varchar(20) DEFAULT NULL COMMENT 'Code provided by Booster for initial login',
            `address` varchar(200) DEFAULT NULL,
            `city` varchar(50) DEFAULT NULL,
            `state` varchar(30) DEFAULT NULL,
            `zip` varchar(10) DEFAULT NULL,
            `country` varchar(50) DEFAULT NULL,
            `company` varchar(50) DEFAULT NULL,
            `gender` varchar(20) DEFAULT NULL,
            `in_service` varchar(20) DEFAULT NULL COMMENT 'This field is used to verify when a user has been terminated. HR updates the field \"VanaHCM__Service_Years__c\" to \"terminated when that happens.',
            `dob` date DEFAULT NULL,
            `origin` varchar(20) DEFAULT NULL COMMENT 'Since users can come from so many places, we need to keep track of that',
            `salesforce_worker_id` varchar(50) DEFAULT NULL,
            `salesforce_user_id` varchar(50) DEFAULT NULL,
            `salesforce_team_id` varchar(50) DEFAULT '',
            `salesforce_profile_id` varchar(50) DEFAULT NULL,
            `salesforce_contact_id` varchar(50) DEFAULT NULL,
            `laps` int(10) unsigned DEFAULT NULL,
            `original_laps_count` int(10) unsigned DEFAULT NULL,
            `laps_modified_by_user_id` int(11) unsigned DEFAULT NULL,
            `laps_modified_ts` timestamp NULL DEFAULT NULL,
            `api_token` varchar(50) DEFAULT NULL,
            `registered` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'flag for student-if completed registration and added parent',
            `waiver_signed` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'flag for student-terms if terms/waiver agreed to',
            `waiver_dob` date DEFAULT NULL,
            `waiver_ts` datetime DEFAULT NULL,
            `deleted` tinyint(4) NOT NULL DEFAULT '0',
            `ts_laps_entered` timestamp NULL DEFAULT NULL,
            `flagging_mode_id` int(11) unsigned DEFAULT '1',
            `block_collection_reminder` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'flag for blocking collection reminder via print or email',
            `reg_code_temp_user` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'flag for initial temp user when using registration code',
            `email_opt_out` tinyint(1) unsigned DEFAULT '0',
            `public_pledger` tinyint(1) DEFAULT '0',
            `requested_pay_later_override` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_email` (`email`),
            UNIQUE KEY `unique_fr_code` (`fr_code`),
            UNIQUE KEY `salesforce_user_id` (`salesforce_user_id`),
            KEY `fk_user_to_user_flagging_mode` (`flagging_mode_id`),
            KEY `username_index` (`username`),
            KEY `forgotten_password_code_index` (`forgotten_password_code`),
            KEY `reg_code_temp_user_index` (`reg_code_temp_user`),
            KEY `created_on_index` (`created_on`),
            KEY `idx_ts_laps_entered` (`ts_laps_entered`),
            KEY `salesforce_team_id_index` (`salesforce_team_id`),
            KEY `salesforce_profile_id_index` (`salesforce_profile_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

            DB::statement('DROP TABLE IF EXISTS `users_notes`;');

            DB::statement('CREATE TABLE `users_notes` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(11) unsigned NOT NULL,
            `note` text NOT NULL,
            `created` datetime NOT NULL,
            `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `users_user_groups`;');

            DB::statement('CREATE TABLE `users_user_groups` (
            `user_id` int(11) unsigned NOT NULL,
            `group_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`user_id`,`group_id`),
            KEY `user_id_index` (`user_id`),
            KEY `group_id_index` (`group_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `veracity_merchants`;');

            DB::statement('CREATE TABLE `veracity_merchants` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `secure_net_id` varchar(64) NOT NULL,
            `secure_net_key` varchar(128) NOT NULL,
            `terminal_username` varchar(128) NOT NULL,
            `terminal_password` varchar(128) NOT NULL,
            `terminal_link` varchar(128) NOT NULL,
            `terminal_number` int(10) unsigned DEFAULT NULL,
            `school_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `fk_school_merchant` (`school_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;');

            DB::statement('DROP TABLE IF EXISTS `videos`;');

            DB::statement('CREATE TABLE `videos` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int(11) unsigned NOT NULL,
            `source` varchar(20) NOT NULL,
            `hash` varchar(100) NOT NULL,
            `original_url` varchar(255) NOT NULL,
            `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

            DB::statement('ALTER TABLE braintree_customers ADD CONSTRAINT `braintree_customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE braintree_merchants ADD CONSTRAINT `braintree_merchants_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`)');
            DB::statement('ALTER TABLE braintree_tokens ADD CONSTRAINT `braintree_tokens_ibfk_1` FOREIGN KEY (`bt_customer_id`) REFERENCES `braintree_customers` (`id`)');
            DB::statement('ALTER TABLE cc_transaction_actions ADD CONSTRAINT `cc_transaction_actions_ibfk_1` FOREIGN KEY (`cc_transaction_id`) REFERENCES `cc_transactions` (`id`)');
            DB::statement('ALTER TABLE email_notifications ADD CONSTRAINT `program_notification_fk` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)');
            DB::statement('ALTER TABLE grade_aliases ADD CONSTRAINT `grade_aliases_ibfk_1` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`)');
            DB::statement('ALTER TABLE hero_video_jobs ADD CONSTRAINT `hero_video_jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE manual_payments ADD CONSTRAINT `fk_entered_by_user` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE manual_payments ADD CONSTRAINT `manual_payments_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)');
            DB::statement('ALTER TABLE manual_payments ADD CONSTRAINT `manual_payments_ibfk_2` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`)');
            DB::statement('ALTER TABLE manual_payments ADD CONSTRAINT `payment_to_classroom` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`)');
            DB::statement('ALTER TABLE online_payments ADD CONSTRAINT `online_payments_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)');
            DB::statement('ALTER TABLE online_pending_payment_pledges ADD CONSTRAINT `online_pending_payment_pledges_ibfk_1` FOREIGN KEY (`online_pending_payments_id`) REFERENCES `online_pending_payments` (`id`)');
            DB::statement('ALTER TABLE online_pending_payment_pledges ADD CONSTRAINT `online_pending_payment_pledges_ibfk_2` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`)');
            DB::statement('ALTER TABLE online_pending_payments ADD CONSTRAINT `online_pending_payments_ibfk_1` FOREIGN KEY (`bt_token_id`) REFERENCES `braintree_tokens` (`id`)');
            DB::statement('ALTER TABLE online_pending_payments ADD CONSTRAINT `online_pending_payments_ibfk_2` FOREIGN KEY (`bt_customer_id`) REFERENCES `braintree_customers` (`id`)');
            DB::statement('ALTER TABLE organization_administrators ADD CONSTRAINT `organization_administrators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE organization_administrators ADD CONSTRAINT `organization_administrators_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`)');
            DB::statement('ALTER TABLE participants ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE');
            DB::statement('ALTER TABLE payments_students ADD CONSTRAINT `payments_students_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)');
            DB::statement('ALTER TABLE pledge_entered_location ADD CONSTRAINT `fk_entered_locations_id_to_entered_locations_id` FOREIGN KEY (`entered_location_id`) REFERENCES `entered_locations` (`id`)');
            DB::statement('ALTER TABLE pledge_entered_location ADD CONSTRAINT `fk_entered_pledges_pledge_id_to_pledge_id` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`)');
            DB::statement('ALTER TABLE pledge_referrers ADD CONSTRAINT `fk_pledge_id_for_referrers` FOREIGN KEY (`pledge_id`) REFERENCES `pledges` (`id`)');
            DB::statement('ALTER TABLE pledge_referrers ADD CONSTRAINT `fk_referrer_id_for_referrers` FOREIGN KEY (`referrer_id`) REFERENCES `referrers` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_sponsor` FOREIGN KEY (`pledge_sponsor_id`) REFERENCES `pledge_sponsors` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_entered_by_user` FOREIGN KEY (`entered_by_user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_last_modified_by_user` FOREIGN KEY (`last_modified_by_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_participant_user` FOREIGN KEY (`participant_user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_payment` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_pledge_sponsor` FOREIGN KEY (`pledge_sponsor_id`) REFERENCES `pledge_sponsors` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_pledge_status` FOREIGN KEY (`pledge_status_id`) REFERENCES `pledge_statuses` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_pledge_substatus` FOREIGN KEY (`pledge_substatus_id`) REFERENCES `pledge_substatuses` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_pledge_type` FOREIGN KEY (`pledge_type_id`) REFERENCES `pledge_types` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_sponsor_type` FOREIGN KEY (`sponsor_type_id`) REFERENCES `sponsor_types` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_sponsor_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `fk_pledge_to_unflagged_by_user` FOREIGN KEY (`unflagged_by`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `parent_payment` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `pledges_ibfk_1` FOREIGN KEY (`participant_user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `pledges_ibfk_2` FOREIGN KEY (`last_modified_by_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE pledges ADD CONSTRAINT `pledges_ibfk_3` FOREIGN KEY (`entered_by_user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE prizes_bound ADD CONSTRAINT `prizes_fk` FOREIGN KEY (`prize_id`) REFERENCES `prizes` (`id`) ON DELETE CASCADE');
            DB::statement('ALTER TABLE prizes_bound_template ADD CONSTRAINT `prizes_list_fk` FOREIGN KEY (`prize_list_id`) REFERENCES `prizes_list` (`id`) ON DELETE CASCADE');
            DB::statement('ALTER TABLE prizes_bound_template ADD CONSTRAINT `prize_fk` FOREIGN KEY (`prize_id`) REFERENCES `prizes` (`id`) ON DELETE CASCADE');
            DB::statement('ALTER TABLE program_pledge_settings ADD CONSTRAINT `fk_program_pledge_settings_to_program` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)');
            DB::statement('ALTER TABLE program_sponsor_ad_locations ADD CONSTRAINT `program_sponsor_ad_locations_ibfk_1` FOREIGN KEY (`program_sponsor_ad_id`) REFERENCES `program_sponsor_ads` (`id`)');
            DB::statement('ALTER TABLE program_sponsor_ad_locations ADD CONSTRAINT `program_sponsor_ad_locations_ibfk_2` FOREIGN KEY (`ad_location_id`) REFERENCES `ad_locations` (`id`)');
            DB::statement('ALTER TABLE program_sponsor_ads ADD CONSTRAINT `program_sponsor_ads_ibfk_1` FOREIGN KEY (`program_sponsor_id`) REFERENCES `program_sponsors` (`id`)');
            DB::statement('ALTER TABLE programs_program_sponsors ADD CONSTRAINT `programs_program_sponsors_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`)');
            DB::statement('ALTER TABLE programs_program_sponsors ADD CONSTRAINT `programs_program_sponsors_ibfk_2` FOREIGN KEY (`program_sponsor_id`) REFERENCES `program_sponsors` (`id`)');
            DB::statement('ALTER TABLE school_escrow_transactions ADD CONSTRAINT `school_fk` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`)');
            DB::statement('ALTER TABLE user_profiles ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE');
            DB::statement('ALTER TABLE users ADD CONSTRAINT `fk_user_to_user_flagging_mode` FOREIGN KEY (`flagging_mode_id`) REFERENCES `user_flagging_modes` (`id`)');
            DB::statement('ALTER TABLE users_notes ADD CONSTRAINT `users_notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE users_notes ADD CONSTRAINT `users_notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)');
            DB::statement('ALTER TABLE veracity_merchants ADD CONSTRAINT `fk_school_merchant` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`)');

            $paid_status = 3;//Pledge_model::PAID_STATUS;
            DB::unprepared("CREATE TRIGGER paid_pledge_check BEFORE UPDATE ON pledges
                FOR EACH ROW
                pledge_check_proc:BEGIN
                    IF @SKIP_TRIGGER = TRUE THEN
                        LEAVE pledge_check_proc;
                    END IF;
                    IF OLD.pledge_status_id = $paid_status AND NEW.pledge_status_id <> OLD.pledge_status_id THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot update paid pledge.';
                    END IF;
                END");

            DB::unprepared('DROP FUNCTION IF EXISTS program_id');
            DB::unprepared('CREATE FUNCTION program_id()
                RETURNS INTEGER DETERMINISTIC NO SQL RETURN @program_id');

            DB::unprepared('DROP FUNCTION IF EXISTS mask_telephone');
            DB::unprepared("CREATE FUNCTION mask_telephone (unformatted_value BIGINT, format_string CHAR(32))
                RETURNS CHAR(32) DETERMINISTIC

                BEGIN
                # Declare variables
                DECLARE input_len TINYINT;
                DECLARE output_len TINYINT;
                DECLARE temp_char CHAR;

                # Initialize variables
                SET input_len = LENGTH(unformatted_value);
                SET output_len = LENGTH(format_string);

                # Construct formated string
                WHILE ( output_len > 0 ) DO

                SET temp_char = SUBSTR(format_string, output_len, 1);
                    IF ( temp_char = '#' ) THEN
                        IF ( input_len > 0 ) THEN
                    SET format_string = INSERT(format_string, output_len, 1, SUBSTR(unformatted_value, input_len, 1));
                        SET input_len = input_len - 1;
                    ELSE
                        SET format_string = INSERT(format_string, output_len, 1, '0');
                        END IF;
                    END IF;

                SET output_len = output_len - 1;
                END WHILE;

                RETURN format_string;
                END");
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
