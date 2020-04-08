<?php

use App\Entities\UserActivity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_activities', function (Blueprint $table) {
            $table->string('category')->default('');
            $table->integer('amount_needed')->default(0);
        });

        $this->updateUserActivity('5 Easy Emails', 5, 'easy_emailer');
        $this->updateUserActivity('10 Easy Emails', 10, 'easy_emailer');
        $this->updateUserActivity('15 Easy Emails', 15, 'easy_emailer');
        $this->updateUserActivity('20 Easy Emails', 20, 'easy_emailer');
        $this->updateUserActivity('Share on Facebook', 1, 'facebook');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_activities', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('amount_needed');
        });
    }

    private function updateUserActivity($name, $amountNeeded, $category)
    {
        UserActivity::where('name', $name)->update([
            'category' => $category,
            'amount_needed' => $amountNeeded
        ]);
    }
}
