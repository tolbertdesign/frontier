<?php

use Illuminate\Database\Seeder;
use App\Entities\UserEmailType;

class UserEmailTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserEmailType::insert([
            ['name' => 'Block All Emails'],
            ['name' => 'Block Automated Pledge Request and Program Update Emails']
        ]);
    }
}
