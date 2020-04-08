<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddIndexesToLotsOfFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            // access_tokens: user_id, access_token (composite)
            Schema::table('access_tokens', function (Blueprint $table) {
                $table->index(['user_id', 'access_token']);
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        // braintree_customers.email
        try {
            Schema::table('braintree_customers', function (Blueprint $table) {
                $table->index('email');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        // cc_transactions.merchant_id
        // cc_transactions.email
        try {
            Schema::table('cc_transactions', function (Blueprint $table) {
                $table->index('email');
                $table->index('merchant_id');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // cc_transaction_pledges.pledge_id
        try {
            Schema::table('cc_transaction_pledges', function (Blueprint $table) {
                $table->index('pledge_id');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // classrooms.grade_id
        try {
            Schema::table('classrooms', function (Blueprint $table) {
                $table->index('grade_id');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // countries.iso (unique)
        // countries.name (unique)
        try {
            Schema::table('countries', function (Blueprint $table) {
                $table->unique('iso');
                $table->unique('name');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // //QUESTIONABLE? is this unique
        // microsite_pics.image (unique) - This needs to be confirmed as to whether it should be unique.
        try {
            Schema::table('microsite_pics', function (Blueprint $table) {
                $table->index('image');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // microsite_videos.hash
        try {
            Schema::table('microsite_videos', function (Blueprint $table) {
                $table->index('hash');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // payment_notify.user_id
        try {
            Schema::table('payment_notify', function (Blueprint $table) {
                $table->index('user_id');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // payments_students.payment_id
        try {
            Schema::table('payments_students', function (Blueprint $table) {
                $table->index('payment_id');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // //QUESTIONABLE? WHY ARE WE DOING THESE?
        // // payment_student_backup.payment_id
        // Schema::table('payment_student_backup', function (Blueprint $table) {
        //     $table->index('payment_id');
        // });
        // // payment_student_backup.student_id
        // Schema::table('payment_student_backup', function (Blueprint $table) {
        //     $table->index('student_id');
        // pledging_start});
        try {
            Schema::dropIfExists('payment_student_backup');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // pledge_notes.pledge_id
        // pledge_notes.entered_by_id
        try {
            Schema::table('pledge_notes', function (Blueprint $table) {
                $table->index('entered_by_id');
                $table->index('pledge_id');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // pledge_sponsors.email
        try {
            DB::statement('ALTER TABLE `pledge_sponsors` ' .
            'CHANGE `ts_updated` `ts_updated` ' .
            "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT '', " .
            'CHANGE `ts_created` `ts_created` ' .
            "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT ''");
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        // DB::statement("ALTER TABLE `pledge_sponsors` CHANGE `ts_updated` `ts_updated` " .
        //     "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT ''");
        // DB::statement("ALTER TABLE `pledge_sponsors` CHANGE `ts_created` `ts_created` " .
        //     "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT ''");
        try {
            Schema::table('pledge_sponsors', function (Blueprint $table) {
                $table->index('email');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // potential_sponsors: participant_user_id, sender_user_id,  and email (together unique)
        // potential_sponsors.sender_user_id
        try {
            Schema::table('potential_sponsors', function (Blueprint $table) {
                $table->index('sender_user_id');
                $table->index(
                    ['participant_user_id', 'sender_user_id', 'email'],
                    'ps_participant_uid_sender_uid_email'
                );
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // prizes.inventory_code
        try {
            Schema::table('prizes', function (Blueprint $table) {
                $table->index('inventory_code');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // prizes_bound.starts_at
        // prizes_bound.ends_at
        // prizes_bound.pledge_period_ordinal
        // prizes_bound.quantity
        // prizes_bound.actual_amount
        // prizes_bound.display_amount
        try {
            Schema::table('prizes_bound', function (Blueprint $table) {
                $table->index('actual_amount');
                $table->index('display_amount');
                $table->index('ends_at');
                $table->index('pledge_period_ordinal');
                $table->index('quantity');
                $table->index('starts_at');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // programs.pledging_start
        // programs.pledging_end
        // programs.school_id
        // programs.fun_run
        // programs.pep_rally
        // programs.team_id
        try {
            Schema::table('programs', function (Blueprint $table) {
                $table->index('fun_run');
                $table->index('pep_rally');
                $table->index('pledging_end');
                $table->index('pledging_start');
                $table->index('school_id');
                $table->index('team_id');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // users.activation_code
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->index('activation_code');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // s3_reports: program_id, type (composite)
        try {
            Schema::table('s3_reports', function (Blueprint $table) {
                $table->index(['program_id', 'type']);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // schools.name
        try {
            Schema::table('schools', function (Blueprint $table) {
                $table->index('name');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        // //QUESTIONABLE? is this unique
        // user_profiles.image_name (unique) -- confirm unique or not
        // if we want to make this unique we need to de-dupe all staging environments
        // de-dupe production and change our local seeders to unique images as well.
        try {
            Schema::table('user_profiles', function (Blueprint $table) {
                $table->index('image_name');
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // access_tokens: user_id, access_token (composite)
        Schema::table('access_tokens', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'access_token']);
        });
        // braintree_customers.email
        Schema::table('braintree_customers', function (Blueprint $table) {
            $table->dropIndex('braintree_customers_email_index');
        });
        // cc_transactions.merchant_id
        // cc_transactions.email
        Schema::table('cc_transactions', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['merchant_id']);
        });
        // cc_transaction_pledges.pledge_id
        Schema::table('cc_transaction_pledges', function (Blueprint $table) {
            $table->dropIndex(['pledge_id']);
        });
        // classrooms.grade_id
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropIndex(['grade_id']);
        });
        // countries.iso (unique)
        // countries.name (unique)
        Schema::table('countries', function (Blueprint $table) {
            $table->dropUnique(['iso']);
            $table->dropUnique(['name']);
        });
        // //QUESTIONABLE? is this unique
        // microsite_pics.image (unique) - This needs to be confirmed as to whether it should be unique.
        Schema::table('microsite_pics', function (Blueprint $table) {
            $table->dropIndex(['image']);
        });
        // microsite_videos.hash
        Schema::table('microsite_videos', function (Blueprint $table) {
            $table->dropIndex(['hash']);
        });
        // payment_notify.user_id
        Schema::table('payment_notify', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });
        // payments_students.payment_id
        Schema::table('payments_students', function (Blueprint $table) {
            $table->dropIndex(['payment_id']);
        });
        // //QUESTIONABLE? WHY ARE WE DOING THESE?
        // // payment_student_backup.payment_id
        // Schema::table('payment_student_backup', function (Blueprint $table) {
        //     $table->index('payment_id');
        // });
        // // payment_student_backup.student_id
        // Schema::table('payment_student_backup', function (Blueprint $table) {
        //     $table->index('student_id');
        // pledging_start});
        Schema::dropIfExists('payment_student_backup');
        // pledge_notes.pledge_id
        // pledge_notes.entered_by_id
        Schema::table('pledge_notes', function (Blueprint $table) {
            $table->dropIndex(['entered_by_id']);
            $table->dropIndex(['pledge_id']);
        });
        // pledge_sponsors.email
        Schema::table('pledge_sponsors', function (Blueprint $table) {
            $table->dropIndex(['email']);
        });
        // potential_sponsors: participant_user_id, sender_user_id,  and email (together unique)
        // potential_sponsors.sender_user_id
        Schema::table('potential_sponsors', function (Blueprint $table) {
            $table->dropIndex(['sender_user_id']);
            $table->dropIndex('ps_participant_uid_sender_uid_email');
        });
        // prizes.inventory_code
        Schema::table('prizes', function (Blueprint $table) {
            $table->dropIndex(['inventory_code']);
        });
        // prizes_bound.starts_at
        // prizes_bound.ends_at
        // prizes_bound.pledge_period_ordinal
        // prizes_bound.quantity
        // prizes_bound.actual_amount
        // prizes_bound.display_amount
        Schema::table('prizes_bound', function (Blueprint $table) {
            $table->dropIndex(['actual_amount']);
            $table->dropIndex(['display_amount']);
            $table->dropIndex(['ends_at']);
            $table->dropIndex(['pledge_period_ordinal']);
            $table->dropIndex(['quantity']);
            $table->dropIndex(['starts_at']);
        });
        // programs.pledging_start
        // programs.pledging_end
        // programs.school_id
        // programs.fun_run
        // programs.pep_rally
        // programs.team_id
        Schema::table('programs', function (Blueprint $table) {
            $table->dropIndex(['fun_run']);
            $table->dropIndex(['pep_rally']);
            $table->dropIndex(['pledging_end']);
            $table->dropIndex(['pledging_start']);
            $table->dropIndex(['school_id']);
            $table->dropIndex(['team_id']);
        });
        // users.activation_code
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['activation_code']);
        });
        // s3_reports: program_id, type (composite)
        Schema::table('s3_reports', function (Blueprint $table) {
            $table->dropIndex(['program_id', 'type']);
        });
        // schools.name
        Schema::table('schools', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
        // //QUESTIONABLE? is this unique
        // user_profiles.image_name (unique) -- confirm unique or not
        // if we want to make this unique we need to de-dupe all staging environments
        // de-dupe production and change our local seeders to unique images as well.
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropIndex(['image_name']);
        });
    }
}
