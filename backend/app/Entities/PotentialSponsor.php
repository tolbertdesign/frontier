<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PotentialSponsor extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'participant_user_id',
        'sender_user_id',
        'sponsor_user_id',
        'enrollment',
        'deleted'
    ];

    public function sponsorUser()
    {
        return $this->belongsTo(User::class, 'sponsor_user_id');
    }

    public function participantUser()
    {
        return $this->belongsTo(User::class, 'participant_user_id');
    }

    public function emailOptOut()
    {
        return $this->hasMany(UserEmailOptOut::class, 'email', 'email');
    }

    public function hasOptedOut()
    {
        if ($this->emailOptOut()->exists()) {
            return true;
        }

        if ((int) $this->opt_out === 1) {
            return true;
        }

        return false;
    }
}
