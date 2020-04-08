<?php

use Illuminate\Database\Seeder;
use App\Entities\UserTaskTemplate;
use App\Entities\UserTaskList;
use App\Entities\UserTaskListTask;

class UserTaskListTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $userTaskLists = UserTaskList::all();
        $userTaskTemplates = UserTaskTemplate::all();
        $events = ['Final Event', 'Pep Rally'];
        $eventOffsets = [-35, -14, -8, -7, -2, 0, 1, 7];

        foreach ($userTaskLists as $listKey => $userTaskList) {
            foreach ($userTaskTemplates as $templateKey => $userTaskTemplate) {
                $addToList = rand(0, 2);
                if ($addToList) {
                    $userTaskListTasks[] = [
                        'user_task_list_id' => $userTaskList->id,
                        'user_task_template_id' => $userTaskTemplate->id,
                        'event' => $events[rand(0, 1)],
                        'event_offset' => $eventOffsets[rand(0, 7)],
                    ];
                }
            }
        }
        UserTaskListTask::insert($userTaskListTasks);
    }
}
