<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserFlaggingMode extends Model
{
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
