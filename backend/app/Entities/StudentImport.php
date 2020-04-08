<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentImport extends Model
{
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
