<?php

namespace App\Models;

use App\Entities\MicrositeVideo;
use stdClass;

class WelcomeVideos
{
    private $participants;

    public function __construct($participants)
    {
        $this->participants = $participants;
    }

    public function getAllPublic()
    {
        $studentStarVideos = $this->getStudentStarVideoUrls()->toArray();
        $otherVideos       = $this->getDashVideosByMicrosite();

        $videos = array_merge($studentStarVideos, $otherVideos);
        return $videos;
    }

    private function getStudentStarVideoUrls()
    {
        $videoUrls = $this->participants->map(function ($participant) {
            $video       = new stdClass();
            $video->type = 'student_star';
            if ($participant->profile->video_url) {
                $video->description = $participant->first_name . '\'s Video';
                $video->source      = 'jwplayer';
                $video->hash        = $participant->profile->video_url;
                $video->embed_uri   = $participant->profile->videoUrl();
                return $video;
            } else {
                return null;
            }
        })->filter(function ($videoUrl) {
            return $videoUrl;
        });
        return $videoUrls;
    }

    /**
     * Check if an image has been uploaded for a participant's student star video
     *
     * @return  Boolean
     */
    public function hasImageForStudentStarVideo()
    {
        if (! empty($this->participants)) {
            foreach ($this->participants as $participant) {
                if (trim($participant->profile->image_name) != '') {
                    return true;
                }
            }
        }

        return false;
    }

    private function getDashVideosByMicrosite()
    {
        $program         = $this->participants->first()->participantInfo->classroom->group->program;
        $microsite       = $program->microsite;

        $micrositeVideos = [];
        if ($microsite) {
            $programVidKeys = ['video_1', 'video_2', 'video_3', 'video_4', 'video_5'];
            foreach ($programVidKeys as $videoKey) {
                if ($microsite->{$videoKey}) {
                    $video             = MicrositeVideo::find($microsite->{$videoKey});
                    $video->embed_uri  = $video->source == 'youtube' ? env('YOUTUBE_BASE_URL') : env('VIMEO_BASE_URL');
                    $video->embed_uri .= $video->hash;
                    array_push($micrositeVideos, $video);
                }
            }
        }

        return $micrositeVideos;
    }
}
