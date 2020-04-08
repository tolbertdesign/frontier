<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserEmailOptOut extends Model
{
    protected $table   = 'user_email_opt_out';
    public $timestamps = false;

    public $fillable = [
        'email',
        'user_email_type_id'
    ];

    public function userEmailType()
    {
        return $this->belongsTo(UserEmailType::class);
    }
}
