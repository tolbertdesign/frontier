<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $fillable = [];

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }
}
