<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserNote extends Model
{
    protected $table   = 'users_notes';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
