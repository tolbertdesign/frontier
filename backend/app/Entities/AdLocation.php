<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\ProgramSponsorAd;

class AdLocation extends Model
{
    public function programSponsorAd()
    {
        return $this->belongsToMany(ProgramSponsorAd::class, 'program_sponsor_ad_locations');
    }
}
