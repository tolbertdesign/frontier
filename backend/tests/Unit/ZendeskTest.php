<?php

namespace Tests\Unit;

use App\Entities\User;
use App\Libraries\Zendesk;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ZendeskTest extends TestCase
{

    public function testZendeskUrlForLoggedInUser()
    {
        $user = User::find(1);
        $zendesk = new Zendesk($user);
        $url = $zendesk->redirectLocation();
        $this->assertContains('https://boosterthon1580156699.zendesk.com/access/jwt?jwt=eyJ', $url);

    }

    public function testZendeskUrlForLoggedOutUser()
    {
        $zendesk = new Zendesk();
        $url = $zendesk->redirectLocation();
        $this->assertEquals($url, 'https://boosterthon1580156699.zendesk.com');
    }

    public function testSupportRouteRedirectForLoggedOutUser()
    {
        $this->get('/v3/support')
            ->assertStatus(302)
            ->assertLocation('https://boosterthon1580156699.zendesk.com');
    }

    public function testSupportRouteRedirectForLoggedInUser()
    {
        $user = User::find(1);
        $this->actingAs($user)
            ->get('/v3/support')
            ->assertStatus(302);

    }

    public function testRedirectFromZendesk()
    {
        $this->get('/v3/support?redirect_to=https://boosterthon.zendesk.com')
            ->assertLocation('https://boosterthon1580156699.zendesk.com');
    }
}
