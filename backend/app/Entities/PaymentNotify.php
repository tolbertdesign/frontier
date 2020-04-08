<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Participant;

class PaymentNotify extends Model
{
    protected $table = 'payment_notify';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }
}
