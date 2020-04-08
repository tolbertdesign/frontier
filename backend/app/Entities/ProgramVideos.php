<?php

namespace App\Entities;

use App\Entities\MicrositeVideo;
use Illuminate\Support\Facades\Cache;
use stdClass;

class ProgramVideos extends Video
{
    private $participantUsers;
    private $defaultIntroVideo;

    public function __construct($participantUsers)
    {
        $this->participantUsers               = $participantUsers;
        $this->defaultIntroVideo              = new stdClass();
        $this->defaultIntroVideo->description = 'Intro Video';
        $this->defaultIntroVideo->hash        = '347646205';
        $this->defaultIntroVideo->source      = 'vimeo';
        $this->defaultIntroVideo->embed_uri   = env('VIMEO_BASE_URL') . $this->defaultIntroVideo->hash;

        parent::__construct();
    }

    private function getDashVideosByMicrosite()
    {
        $program         = $this->participantUsers->first()->getProgram();
        $microsite       = $program->microsite;

        $videos = [];
        if ($microsite) {
            if ($microsite->intro_vid_override == 0) {
                $videos[0]      = $this->defaultIntroVideo;
                $programVidKeys = ['video_1', 'video_2', 'video_3', 'video_4', 'video_5'];
            } else {
                $programVidKeys = ['intro_vid_override', 'video_1', 'video_2', 'video_3', 'video_4', 'video_5'];
            }

            foreach ($programVidKeys as $videoKey) {
                if ($microsite->{$videoKey} && $microsite->{$videoKey} != 0) {
                    $video             = MicrositeVideo::find($microsite->{$videoKey});
                    $video->embed_uri  = $video->source == 'youtube' ? env('YOUTUBE_BASE_URL') : env('VIMEO_BASE_URL');
                    $video->embed_uri .= $video->hash;
                    array_push($videos, $video);
                }
            }
        }

        return $videos;
    }

    /**
     * Get program videos and cache them for a month
     *
     * @return array $programVideos
     */
    public function getVideos()
    {
        $programVideos = Cache::remember(
            'programVideos.' . $this->participantUsers->first()->getProgram()->id,
            now()->addMonths(1),
            function () {
                $videos = $this->getDashVideosByMicrosite();
                return $this->addThumbnails($videos);
            }
        );

        return $programVideos;
    }
}
