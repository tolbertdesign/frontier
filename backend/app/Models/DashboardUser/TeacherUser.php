<?php

namespace App\Models\DashboardUser;

use App\Models\DashboardUser\User;

class TeacherUser extends User
{
    protected function getRelationships()
    {
        $relationships = parent::getRelationships();
        $relationships[] = 'participants.userTasks';

        return $relationships;
    }

    public function get()
    {
        $this->user->append('class_last_name')->append('class_pledge_total')->append('teacher_participant_id');

        return parent::get();
    }
}
