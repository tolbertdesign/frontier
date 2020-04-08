<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class GradeAlias extends Model
{
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
