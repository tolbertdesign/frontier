<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserActivityHistory extends Model
{
    protected $table   = 'user_activity_history';
    public $timestamps = false;

    protected $fillable = ['user_id', 'activity_id'];
}
