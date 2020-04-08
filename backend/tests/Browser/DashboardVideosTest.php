<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Entities\User;
use App\Entities\MicrositeVideo;
use App\Entities\Video;

class DashboardVideosTest extends DuskTestCase
{
    private $user;
    private $participantUser;

    public function setUp() : void
    {
        parent::setUp();
        $this->user            = User::where('email', 'parent@example.com')->first();
        $this->participantUser = $this->user->participants->first();
    }

    /**
     * Test for program videos
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testProgramVideos()
    {
        $micrositeVideo  = MicrositeVideo::find(1);
        $response        = $this->actingAs($this->user, 'web')
            ->get('/v3/api/videos/program/' . $this->participantUser->id)
            ->assertStatus(200);

        $response->assertJsonFragment([
            'description' => $micrositeVideo->description,
        ]);
    }

    /**
     * Test for character videos
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCharacterVideos()
    {
        $characterVideo = Video::find(1);
        $response       = $this->actingAs($this->user, 'web')
            ->get('/v3/api/videos/character')
            ->assertStatus(200);

        $response->assertJsonFragment([
            'title' => $characterVideo->title,
        ]);
    }
}
