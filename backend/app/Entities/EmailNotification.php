<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
