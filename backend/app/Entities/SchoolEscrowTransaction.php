<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SchoolEscrowTransaction extends Model
{
    protected $primaryKey = 'transaction_id';
    public $incrementing  = false;
    public $timestamps    = false;

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
