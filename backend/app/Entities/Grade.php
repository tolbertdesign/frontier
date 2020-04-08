<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public $timestamps = false;

    public function gradeAliases()
    {
        return $this->hasMany(GradeAlias::class);
    }

    public function classroom()
    {
        return $this->hasMany(Classroom::class);
    }
}
