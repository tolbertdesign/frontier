<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

class UserProfile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'pledge_goal',
        'created',
        'pledge_goal',
        'image_name'
    ];

    public function imageUrl()
    {
        return ($this->image_name) ?
            env('S3_BUCKET') . 'user_profile_images/' . $this->image_name
            : null;
    }

    public function videoUrl()
    {
        if ($this->video_url) {
            return env('JWPLAYER_BASE_URL') . $this->video_url . '-' . env('JWPLAYER_CONFIG') . '.html';
        }
        return '';
    }

    public function getPledgePageTextAttribute($dirtyHtml)
    {
        $cachePath = base_path('bootstrap/cache');

        $config = [
            'Core.Encoding'             => 'utf-8',
            'HTML.Doctype'              => 'HTML 4.01 Transitional',
            'HTML.Allowed'              => 'p,strong,b,em,i,li,ol,ul,a[href],a[target],br,div,span,u',
            'HTML.TidyLevel'            => 'light',
            'AutoFormat.RemoveEmpty'    => true,
            'Cache.SerializerPath'      => $cachePath,
            'Attr.AllowedFrameTargets'  => ['_blank', '_self', '_parent', '_top']
        ];

        return Purify::clean($dirtyHtml, $config);
    }
}
