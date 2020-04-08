<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserTaskTemplate extends Model
{

    public $timestamps = false;

    public function userTasks()
    {
        return $this->hasMany(UserTask::class, 'task_template_id');
    }

    public function userTaskListTasks()
    {
        return $this->hasMany(UserTaskListTask::class);
    }
}
