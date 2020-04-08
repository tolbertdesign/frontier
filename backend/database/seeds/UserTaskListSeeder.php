<?php

use Illuminate\Database\Seeder;
use App\Entities\UserTaskList;

class UserTaskListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=1; $i <= 25; $i++) {
            $userTaskLists[] = [
                'name' => 'Task List #'.$i
            ];
        }
        UserTaskList::insert($userTaskLists);
    }
}
