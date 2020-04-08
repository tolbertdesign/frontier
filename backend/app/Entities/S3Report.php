<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class S3Report extends Model
{
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
