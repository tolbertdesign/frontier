<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserTaskListTask extends Model
{
    public function userTaskList()
    {
        return $this->belongsTo(UserTaskList::class);
    }

    public function userTaskTemplate()
    {
        return $this->belongsTo(UserTaskTemplate::class);
    }
}
