<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function studentImport()
    {
        return $this->hasMany(StudentImport::class);
    }

    public function prizesBound()
    {
        return $this->hasMany(PrizesBound::class);
    }
}
