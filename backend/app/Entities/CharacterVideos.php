<?php

namespace App\Entities;

use Illuminate\Support\Facades\Cache;

class CharacterVideos extends Video
{
    protected $table = 'videos';

    /**
     * Get character videos and cache it for a month
     *
     * @return array $characterVideos
     */
    public function getVideos()
    {
        $videos = $this->select('videos.external_video_id', 'videos.source', 'videos.title', 'videos.description')
            ->characterVideos()
            ->orderBy('videos.display_order')
            ->get();

        $characterVideos = Cache::remember('characterVideos', now()->addMonths(1), function () use ($videos) {
            return $this->addThumbnails($videos);
        });

        if (empty($characterVideos)) {
            $characterVideos = [];
        }

        return $characterVideos;
    }
}
