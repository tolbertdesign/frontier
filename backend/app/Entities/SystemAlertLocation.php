<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemAlertLocation extends Model
{
    public function systemAlert()
    {
        return $this->belongsTo(SystemAlert::class);
    }
}
