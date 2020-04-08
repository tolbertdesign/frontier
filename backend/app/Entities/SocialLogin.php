<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SocialLogin extends Model
{
    protected $fillable = ['google'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
