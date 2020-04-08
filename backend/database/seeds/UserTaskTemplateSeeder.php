<?php

use Illuminate\Database\Seeder;
use App\Entities\UserTaskTemplate;

class UserTaskTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(UserTaskTemplate::class, 30)->make()->each(function ($userTaskTemplate) {
            $userTaskTemplate->save();
        });
    }
}
