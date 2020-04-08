<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    public $timestamps = false;

    public function prizesBound()
    {
        return $this->hasMany(PrizesBound::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'prizes_bound_student', 'prize_id', 'student_id');
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'prizes_bound_student', 'prize_id', 'student_id');
    }

    public function prizesBoundTemplates()
    {
        return $this->hasMany(PrizesBoundTemplate::class);
    }
}
