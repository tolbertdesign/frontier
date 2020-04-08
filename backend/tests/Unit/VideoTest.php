<?php

namespace Tests\Unit;

use App\Entities\Video;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test for the youtube thumbnail thumbnail url.
     *
     * @return void
     */
    public function testGetYoutubeThumbnailUrl()
    {
        $video = new Video();
        $url   = $video->getYoutubeThumbnailUrl(12345);
        $this->assertSame($url, env('YOUTUBE_API_URL') . 12345 . '/0.jpg');
    }

    /**
     * A test to check the video source for a vimeo video with an external video id.
     *
     * @return void
     */
    public function testCheckVideoSourceForVimeoVideoWithExternalVideoId()
    {
        $video = Video::whereNotNull('external_video_id')
            ->where('source', 'vimeo')
            ->first();

        $this->assertObjectNotHasAttribute('thumbnail', $video);

        $videoEntity = new Video();
        $video = $videoEntity->checkVideoSource(0, $video);

        $this->assertEmpty($video->thumbnail);
        $this->assertTrue($videoEntity->vimeoCallRequired);
        $this->assertIsArray($videoEntity->vimeoVideoIndexArray);
        $this->assertSame($videoEntity->vimeoVideoIndexArray, [$video->external_video_id]);
    }

    /**
     * A test to check the video source for a vimeo video without an external video id.
     *
     * @return void
     */
    public function testCheckVideoSourceForVimeoVideoWithoutExternalVideoId()
    {
        $videoData = [
            'external_video_id' => 5,
            'title'             => 'title',
            'description'       => 'description',
            'display_order'     => 100,
            'source'            => 'vimeo'
        ];

        Video::insert($videoData);
        $video = Video::where($videoData)->first();

        unset($video->external_video_id);
        $video->hash = 'Hash String';

        $this->assertObjectNotHasAttribute('thumbnail', $video);
        $this->assertEmpty($video->external_video_id);

        $videoEntity = new Video();
        $video = $videoEntity->checkVideoSource(0, $video);

        $this->assertEmpty($video->thumbnail);
        $this->assertFalse($videoEntity->vimeoCallRequired);
        $this->assertIsArray($videoEntity->vimeoVideoIndexArray);
        $this->assertSame($videoEntity->vimeoVideoIndexArray, []);
        $this->assertSame($video->hash, $video->external_video_id);
    }

    /*
     * A test to check the vimeo URL for the guzzle request with multiple vimeo videos.
     *
     * @return void
     */
    public function testCheckVideoSourceForMultipleVimeoVideos()
    {
        $videoData1 = [
            'external_video_id' => 1,
            'title'             => 'title',
            'description'       => 'description',
            'display_order'     => 100,
            'source'            => 'vimeo'
        ];

        Video::insert($videoData1);
        $video1 = Video::where($videoData1)->first();

        $videoData2 = [
            'external_video_id' => 2,
            'title'             => 'title',
            'description'       => 'description',
            'display_order'     => 100,
            'source'            => 'vimeo'
        ];

        Video::insert($videoData2);
        $video2 = Video::where($videoData2)->first();

        $videos = [$video1, $video2];
        $videoEntity = new Video();
        foreach ($videos as $key => $video) {
            $video = $videoEntity->checkVideoSource($key, $video);
        }

        $urlParams = '?uris=/videos/1,/videos/2';
        $this->assertSame($videoEntity->vimeoThumbnailUrl, $urlParams);
    }

    /**
     * A test to check the video source for a youtube video.
     *
     * @return void
     */
    public function testCheckVideoSourceForYoutubeVideo()
    {
        $videoData = [
            'external_video_id' => 'String Value',
            'title'             => 'title',
            'description'       => 'description',
            'display_order'     => 100,
            'source'            => 'youtube'
        ];

        Video::insert($videoData);
        $video = Video::where($videoData)->first();
        $this->assertObjectNotHasAttribute('thumbnail', $video);
        $this->assertNull($video->thumbnail);

        $videoEntity = new Video();
        $videoEntity->checkVideoSource(0, $video);
        $youtubeUrl = $videoEntity->getYoutubeThumbnailUrl($video->external_video_id);

        $this->assertSame($video->thumbnail, $youtubeUrl);
    }
}
