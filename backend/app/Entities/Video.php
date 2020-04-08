<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\VideoCategory;
use GuzzleHttp\Client;

class Video extends Model
{
    public $vimeoCallRequired    = false;
    public $vimeoVideoIndexArray = [];
    public $vimeoThumbnailUrl;
    protected $vimeoHeaders;
    protected $fillable = [
        'external_video_id',
        'source',
        'description',
        'title'
    ];

    public function scopeCharacterVideos($query)
    {
        return $query->join('video_categories', 'videos.video_category_id', '=', 'video_categories.id')
            ->where('video_categories.name', 'character_videos');
    }

    public function __construct()
    {
        $this->vimeoThumbnailUrl = env('VIMEO_API_URL') . '?uris=';
        $this->vimeoHeaders      = [
            'headers' => [
                'Authorization' => 'bearer ' . env('VIMEO_ACCESS_TOKEN'),
                'Accept'        => 'application/vnd.vimeo.*+json;version=3.4',
            ]
        ];
    }

    public function videoCategory()
    {
        return $this->belongsTo(VideoCategory::class, 'video_id');
    }

    /**
     * Add thumbnails to videos object.
     *
     * @param array $videos
     * @return array $videos
     */
    public function addThumbnails($videos)
    {
        foreach ($videos as $key => $video) {
            $video = $this->checkVideoSource($key, $video);
        }
        if ($this->vimeoCallRequired && count($this->vimeoVideoIndexArray) > 0) {
            return $this->attachThumbnailsToVimeoVideos($videos);
        }

        return $videos;
    }

    /**
     * Check the source of the video.
     *
     * @param  Video  $video
     * @return  Video  $video
     */
    public function checkVideoSource($key, $video)
    {
        $videoId          = '';
        $video->thumbnail = env('YOUTUBE_API_URL') . env('YOUTUBE_DEFAULT_THUMBNAIL');

        if (isset($video->external_video_id)) {
            $videoId = $video->external_video_id;
        } elseif ($video->hash) {
            $video->external_video_id = $video->hash;
            $videoId                  = $video->hash;
        }

        if ($video->source == 'vimeo' && is_numeric($videoId)) {
            $this->addVimeoVideo($key, $videoId);
        } elseif ($video->source == 'youtube') {
            $video->thumbnail = $this->getYoutubeThumbnailUrl($videoId);
        }

        return $video;
    }

    /**
     * Add thumbnails to the video object for all vimeo videos.
     *
     * @param  Array  $videos
     * @return  Array  $videos
     */
    public function attachThumbnailsToVimeoVideos($videos)
    {
        $thumbnails = $this->getThumbnailsFromVimeo();

        foreach ($this->vimeoVideoIndexArray as $key => $val) {
            foreach ($thumbnails as $thumbnail) {
                if ($val == substr($thumbnail->uri, 8)) {
                    $videos[$key]->thumbnail = $thumbnail->pictures->sizes[4]->link;
                    break;
                }
            }
        }

        return $videos;
    }

    /**
     * Add Vimeo thumbnail to the list of videos.
     *
     * @param  Integer  $videoId
     * @return  void
     */
    public function addVimeoVideo($key, $videoId)
    {
        $this->addVideoToVimeoApiUrl($videoId);
        $this->vimeoCallRequired          = true;
        $this->vimeoVideoIndexArray[$key] = $videoId;
    }

    /**
     * Add new video to the vimeo thumbnail URL.
     *
     * @param  Integer  $videoId
     * @return  void
     */
    public function addVideoToVimeoApiUrl($videoId)
    {
        if ($this->vimeoCallRequired) {
            $this->vimeoThumbnailUrl .= ',/videos/' . $videoId;
        } else {
            $this->vimeoThumbnailUrl .= '/videos/' . $videoId;
        }
    }

    /**
     * Set youtube video thumbnail URL.
     *
     * @param  Integer  $videoId
     * @return  String
     */
    public function getYoutubeThumbnailUrl($videoId)
    {
        return env('YOUTUBE_API_URL') . $videoId . '/0.jpg';
    }

    /**
     * Make Guzzle call with all of the vimeo video IDs to get thumbnails.
     *
     * @return  Array
     */
    public function getThumbnailsFromVimeo()
    {
        $client = new Client();

        $jsonResult = $client->get(
            $this->vimeoThumbnailUrl,
            $this->vimeoHeaders
        )->getBody()->getContents();

        return json_decode($jsonResult)->data;
    }
}
