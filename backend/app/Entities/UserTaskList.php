<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserTaskList extends Model
{
    public function userTaskListTasks()
    {
        return $this->hasMany(UserTaskListTask::class);
    }
}
