<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentsStudent extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'student_id',
        'amount',
        'add_to_envelope'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function populatePaymentsStudents($participantUser, $payment, $pledge)
    {
        $this->payment_id      = $payment->id;
        $this->student_id      = $participantUser->id;
        $this->amount          = $pledge->amount;
        $this->add_to_envelope = 0;
    }
}
