<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentsParent extends Model
{
    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class);
    }
}
