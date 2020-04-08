<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\AdLocation;
use App\Entities\ProgramSponsor;

class ProgramSponsorAd extends Model
{
    public $timestamps = false;

    public function programSponsor()
    {
        return $this->belongsTo(ProgramSponsor::class);
    }

    public function adLocations()
    {
        return $this->belongsToMany(AdLocation::class, 'program_sponsor_ad_locations');
    }

    public static function processAdText(ProgramSponsorAd $ad, $variables = [])
    {
        foreach ($variables as $key => $value) {
            $search      = '${' . $key . '}';
            $ad->ad_text = str_replace($search, $value, $ad->ad_text);
        }
        return $ad->ad_text;
    }
}
