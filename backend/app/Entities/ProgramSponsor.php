<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\ProgramSponsorAd;

class ProgramSponsor extends Model
{
    public $timestamps = false;

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'programs_program_sponsors');
    }

    public function programSponsorAds()
    {
        return $this->hasMany(ProgramSponsorAd::class);
    }
}
