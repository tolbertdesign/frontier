<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class UserTask extends Model
{
    protected $fillable = [
        'program_id',
        'assigned_to_user_id',
        'type',
        'title',
        'created_by_user_id',
    ];

    protected $casts = [
        'completed_on_date' => 'datetime:c'
    ];

    public function userTaskTemplate()
    {
        return $this->belongsTo(UserTaskTemplate::class, 'task_template_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function setAsIncomplete()
    {
        $this->completed_on_date = null;
        $this->completed_by_user_id = null;
    }

    public function setAsComplete()
    {
        $this->completed_on_date = Carbon::now();
        $this->completed_by_user_id = Auth::id();
    }
}
