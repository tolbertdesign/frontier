<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserEmailType extends Model
{
    public function userEmailOptOuts()
    {
        return $this->hasMany(UserEmailOptOut::class);
    }
}
