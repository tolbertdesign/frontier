<?php

use Illuminate\Database\Seeder;
use App\Entities\UserTask;
use App\Entities\UserTaskTemplate;
use App\Entities\Participant;
use App\Entities\User;
use App\Entities\UserTaskListTask;
use App\Entities\Program;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get programs
        $programs = Program::all();

        //get non-participant users
        $participants   = Participant::pluck('user_id')->all();
        $users          = User::whereNotIn('id', $participants)->orderByRaw('RAND()')->take(10)->get();

        //get tasktemplates
        $userTaskListTasks = UserTaskListTask::all();

        foreach ($userTaskListTasks as $key => $userTaskListTask) {
            $program       = $programs->random();
            $assignedUser  = $users->random();
            $completedDate = $completedByUserId = null;

            if ($userTaskListTask->event == 'Final Event') {
                $eventDate = $program->fun_run;
            } else {
                $eventDate = $program->pep_rally;
            }

            $markAsCompleted = ! (rand(0, 2));

            if ($markAsCompleted) {
                $completedDate     = date('Y-m-d 12:00:00', strtotime('now'));
                $completedByUserId = $assignedUser->id;
            }

            $tasks[] = [
                'program_id'           => $program->id,
                'task_template_id'     => $userTaskListTask->user_task_list_id,
                'assigned_to_user_id'  => $assignedUser->id,
                'type'                 => 'Program',
                'title'                => $userTaskListTask->userTaskTemplate->title,
                'label'                => $userTaskListTask->userTaskTemplate->label,
                'due_date'             => date(
                    'Y-m-d 12:00:00',
                    strtotime($eventDate . ' ' . $userTaskListTask->event_offset . ' Weekday')
                ),
                'completed_on_date'    => $completedDate,
                'completed_by_user_id' => $completedByUserId,
                'created_by_user_id'   => rand(1, 3),
            ];
        }

        UserTask::insert($tasks);
    }
}
