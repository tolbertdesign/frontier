<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ManualPayment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'entered_by',
        'type',
        'check_number',
        'classroom_id'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
