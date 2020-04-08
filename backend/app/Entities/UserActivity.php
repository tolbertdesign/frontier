<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    public $timestamps = false;

    const EASY_EMAILER = 'easy_emailer';
    const FACEBOOK     = 'facebook';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_activity_history', 'activity_id', 'user_id');
    }
}
