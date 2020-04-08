<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomProgramAlert extends Model
{
    /**
     * Turn off timestamps.
     */
    public $timestamps = false;

    protected $casts = [
        'start' => 'datetime:c',
        'end'   => 'datetime:c'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
