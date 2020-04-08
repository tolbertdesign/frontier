<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CollectionReminderHistory extends Model
{
    protected $table = 'collection_reminder_history';

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
