<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SpecialUrl extends Model
{
    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pledgeProcessUrl()
    {
        return secure_url('/public_dashboard/pledge/' . $this->slug);
    }

    public function referrer()
    {
        return $this->belongsTo(Referrer::class);
    }

    public function UTMLink()
    {
        $referrer = $this->referrer;
        $link     = '?utm_source=' . $referrer->source .
                '&utm_medium=' . $referrer->medium .
                '&utm_content=' . $referrer->content .
                '&utm_campaign=' . $referrer->campaign;
        return $link;
    }
}
