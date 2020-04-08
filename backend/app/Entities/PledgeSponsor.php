<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PledgeSponsor extends Model
{
    public $timestamps  = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    public function pledges()
    {
        return $this->hasMany(Pledge::class);
    }

    public function countryEntity()
    {
        return $this->hasOne(Country::class, 'iso', 'country');
    }

    public function emailOptOut()
    {
        return $this->hasMany(UserEmailOptOut::class, 'email', 'email');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    public function hasOptedOut()
    {
        if ($this->emailOptOut()->exists()) {
            return true;
        }

        if ($this->user && (int) $this->user->email_opt_out === 1) {
            return true;
        }

        return false;
    }
}
