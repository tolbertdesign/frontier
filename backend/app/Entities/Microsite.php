<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;
use App\Entities\MicrositePic;

class Microsite extends Model
{
    public $timestamps = false;
    protected $appends = ['images', 'decoded_funds_raised_for'];

    public function micrositeColorTheme()
    {
        return $this->belongsTo(MicrositeColorTheme::class, 'color_theme_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function getImagesAttribute()
    {
        return $this->fundsRaisedImageUrls();
    }

    public function fundsRaisedImageUrls()
    {
        $images = collect([
            $this->pic_1,
            $this->pic_2,
            $this->pic_3,
        ]);
        $imagesFiltered = $images->filter(
            function ($pic) {
                if ($pic !== null && $pic !== '') {
                    return true;
                } else {
                    return false;
                }
            }
        );

        $micrositePics = MicrositePic::find($imagesFiltered);
        return $micrositePics->map(function ($micrositePic) {
            return env('S3_BUCKET') . 'microsites/' . $micrositePic->image;
        });
    }

    public function getDefaultFundsRaisedImage1()
    {
        return env('S3_BUCKET') . 'microsites/' . 'defaultFundsRaisedImage1.png';
    }

    public function getOverviewTextOverrideAttribute($dirtyHtml)
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

    public function getPledgesVideo()
    {
        $getPledgesVideoOverride = $this->get_pledges_vid_override;
        if ($getPledgesVideoOverride) {
            $micrositeVideo           = MicrositeVideo::find($getPledgesVideoOverride);
            $video                    = new Video();
            $video->external_video_id = $micrositeVideo->hash;
            $video->source            = $micrositeVideo->source;
            $video->description       = $micrositeVideo->description;
            $video->title             = $micrositeVideo->description;
        } else {
            $video = VideoCategory::where('name', 'how_to_get_pledges')->first()->videos->first();
        }
        return $video;
    }

    public function fundsRaisedVideoUrl()
    {
        //STUB: Future "Our Goal" video
        return null;
    }

    public function schoolImageUrl()
    {
        if ($this->school_image_name) {
            return env('S3_BUCKET') . 'program_logos/' . $this->school_image_name;
        }
        return null;
    }

    public function getDecodedFundsRaisedForAttribute()
    {
        return html_entity_decode($this->funds_raised_for);
    }
}
