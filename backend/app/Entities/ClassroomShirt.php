<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ClassroomShirt extends Model
{
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
