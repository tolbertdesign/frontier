<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MerchantAccountTypeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('braintree_merchants', function (Blueprint $table) {
            if (! Schema::hasColumn('braintree_merchants', 'account_type')) {
                $table->string('account_type', 40);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('braintree_merchants', function (Blueprint $table) {
            if (Schema::hasColumn('braintree_merchants', 'account_type')) {
                $table->dropColumn('account_type');
            }
        });
    }
}
