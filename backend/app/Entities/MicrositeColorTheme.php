<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MicrositeColorTheme extends Model
{
    public $timestamps = false;

    const DEFAULT_THEME = 'default_theme';

    public function microsites()
    {
        return $this->hasMany(Microsite::class, 'color_theme_id');
    }
}
