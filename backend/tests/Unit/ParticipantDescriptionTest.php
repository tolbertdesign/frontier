<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\Participant;
use App\Models\Shared\FamilyPledging;
use App\Models\WelcomeVideos;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipantDescriptionTest extends TestCase
{
    use DatabaseTransactions;

    public function testCustomWelcomeTextDisplaySuccess()
    {
        $specialUrl = Participant::first()
            ->user
            ->specialUrls
            ->random();

        $specialUrl->user->profile->pledge_page_text = 'Test pledge page text';
        $specialUrl->user->profile->save();
        $description = $specialUrl->user->profile->pledge_page_text;

        $shortKey = $specialUrl->short_key;
        $this->call(
            'get',
            '/v3/dash/' . $shortKey . $specialUrl->UTMLink(),
            [],
            ['use_new_public_page'=> '1']
        )
        ->assertStatus(200)
        ->assertViewIs('public_dash')
        ->assertSee($description);
    }

    public function testDefaultWelcomeTextDisplaySuccess()
    {
        $specialUrl = Participant::first()
            ->user
            ->specialUrls
            ->random();

        $programPledgeSettings = $specialUrl->user
            ->participantInfo
            ->classroom
            ->group
            ->program
            ->getProgramPledgeSetting();
        $programPledgeSettings->flat_donate_only = 0;
        $programPledgeSettings->save();
        $specialUrl->user->profile->pledge_page_text = null;
        $specialUrl->user->profile->save();
        $description = 'Our school is hosting a fundraiser';

        $shortKey = $specialUrl->short_key;
        $this->call(
            'get',
            '/v3/dash/' . $shortKey . $specialUrl->UTMLink(),
            [],
            ['use_new_public_page'=> '1']
        )
        ->assertStatus(200)
        ->assertViewIs('public_dash')
        ->assertSee($description);
    }

    public function testVideoCountSuccess()
    {
        $user                                = Participant::first()->user;
        $familyPledging                      = new FamilyPledging();
        $participants                        = $familyPledging->participants($user);
        $participants[0]->profile->video_url = null;
        $participants[0]->profile->save();
        $participants[1]->profile->video_url = null;
        $participants[1]->profile->save();
        $welcomeVideos      = new WelcomeVideos($participants);

        $this->assertCount(5, $welcomeVideos->getAllPublic());

        $participants[0]->profile->video_url = null;
        $participants[0]->profile->save();
        $participants[1]->profile->video_url = 'testUrl';
        $participants[1]->profile->save();
        $welcomeVideos      = new WelcomeVideos($participants);

        $this->assertCount(6, $welcomeVideos->getAllPublic());

        $participants[0]->profile->video_url = 'testUrl';
        $participants[0]->profile->save();
        $participants[1]->profile->video_url = 'fakeUrl';
        $participants[1]->profile->save();
        $welcomeVideos      = new WelcomeVideos($participants);

        $this->assertCount(7, $welcomeVideos->getAllPublic());
    }
}
