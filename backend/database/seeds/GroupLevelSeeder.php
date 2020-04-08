<?php

use Illuminate\Database\Seeder;
use App\Entities\GroupLevel;

class GroupLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupLevel::insert([
            ['name' =>'Primary'],
            ['name' => 'Middle'],
            ['name' => 'High'],
            ['name' => 'All'],
        ]);
    }
}
