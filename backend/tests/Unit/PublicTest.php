<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Participant;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Config;

class PublicTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublicLoadSuccess()
    {
        $specialUrl = $this->getRandomSpecialUrl();

        $this->call(
            'get',
            '/v3/dash/' . $specialUrl->short_key . $specialUrl->UTMLink(),
            [],
            ['use_new_public_page'=> '1']
        )
        ->assertStatus(200)
        ->assertViewIs('public_dash');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublicLoadKillSwitch()
    {
        $specialUrl = $this->getRandomSpecialUrl();
        $redirectUrl = '/a/s/' . $specialUrl->short_key;
        Config::set('booster.TITAN_KILL_SWITCH', true);

        $this->call(
            'get',
            '/v3/dash/' . $specialUrl->short_key . $specialUrl->UTMLink(),
            [],
            ['use_new_public_page'=> '1']
        )
        ->assertStatus(302)
        ->assertRedirect(secure_url($redirectUrl));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublicLoadNoUtm()
    {
        $specialUrl = $this->getRandomSpecialUrl();
        $redirectUrl = '/v3/dash/' . $specialUrl->short_key . $specialUrl->UTMLink();

        $this->call(
            'get',
            '/v3/dash/' . $specialUrl->short_key,
            [],
            ['use_new_public_page'=> '1']
        )
        ->assertStatus(302)
        ->assertRedirect(secure_url($redirectUrl));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublicLoadBadReferrer()
    {
        $specialUrl = Participant::first()
            ->user
            ->specialUrls
            ->where('referrer_id', 21)
            ->first();
        $specialUrl->referrer_id = 2100;
        $specialUrl->save();

        $this->call(
            'get',
            '/v3/dash/' . $specialUrl->short_key,
            [],
            ['use_new_public_page'=> '1']
        )
        ->assertStatus(200)
        ->assertViewIs('public_dash');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublicLoadBadKey()
    {
        $specialUrl = $this->getRandomSpecialUrl();
        $this->call(
            'get',
            '/v3/dash/' . $specialUrl->short_key . 'fakeValue' . $specialUrl->UTMLink(),
            [],
            ['use_new_public_page'=> '1']
        )
        ->assertStatus(404);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPublicLoadAllSpecialUrlsSuccess()
    {
        $numParticipantsToTest = 3;
        $participants          = Participant::take($numParticipantsToTest)->with('user.specialUrls')->get();

        $this->assertCount($numParticipantsToTest, $participants);
        foreach ($participants as $participant) {
            foreach ($participant->user->specialUrls as $specialUrl) {
                $result = $this->call(
                    'get',
                    '/v3/dash/' . $specialUrl->short_key . $specialUrl->UTMLink(),
                    [],
                    ['use_new_public_page'=> '1']
                );
                $result->assertStatus(200)->assertViewIs('public_dash');
            }
        }
    }

    private function getRandomSpecialUrl()
    {
        return Participant::first()
            ->user
            ->specialUrls
            ->random();
    }
}
