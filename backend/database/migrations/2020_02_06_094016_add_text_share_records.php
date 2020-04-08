<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entities\UserActivity;

class AddTextShareRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        UserActivity::insert([
            [
                'name'          => '3 Text Shares',
                'category'      => 'sms',
                'amount_needed' => 3
            ],
            [
                'name'          => '5 Text Shares',
                'category'      => 'sms',
                'amount_needed' => 5
            ],
            [
                'name'          => '10 Text Shares',
                'category'      => 'sms',
                'amount_needed' => 10
            ],
            [
                'name'          => '15 Text Shares',
                'category'      => 'sms',
                'amount_needed' => 15
            ],
            [
                'name'          => '20 Text Shares',
                'category'      => 'sms',
                'amount_needed' => 20
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        UserActivity::whereIn('name', [
            '3 Text Shares',
            '5 Text Shares',
            '10 Text Shares',
            '15 Text Shares',
            '20 Text Shares'
        ])->delete();
    }
}
