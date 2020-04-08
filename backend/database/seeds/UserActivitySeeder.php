<?php

use Illuminate\Database\Seeder;
use App\Entities\UserActivity;

class UserActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserActivity::insert([
            ['name' => 'Share On Facebook', 'category' => 'facebook', 'amount_needed' => 1],
            ['name' => '5 Easy Emails', 'category' => 'easy_emailer', 'amount_needed' => 5]
        ]);
    }
}
