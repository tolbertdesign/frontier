<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PrizesBoundStudent extends Model
{
    protected $table        = 'prizes_bound_student';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_GIVEAWAY   = 'giveaway';
    const STATUS_PENDING    = 'pending';
    const STATUS_UNASSIGNED = 'unassigned';

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
