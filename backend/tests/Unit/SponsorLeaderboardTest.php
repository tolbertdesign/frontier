<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\SponsorLeaderboard;
use App\Entities\User;
use function bar\baz\foo;

class SponsorLeaderboardTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLeaderboardPledgesCountSuccess()
    {
        $participants         = User::where('email', 'parent@boosterthon.com')->first()->participants;
        $sponsorLeaderboard   = new SponsorLeaderboard($participants);
        $pledges              = $sponsorLeaderboard->getPledges();
        $this->assertEquals(10, $pledges->count());
    }

    public function testLeaderboardPledgesCountOrder()
    {
        $expectedOrder      = collect([80, 80, 60, 60, 40, 40, 30, 30, 10, 10]);

        $participants       = User::where('email', 'parent@boosterthon.com')->first()->participants;
        $sponsorLeaderboard = new SponsorLeaderboard($participants);
        $pledges            = $sponsorLeaderboard->getPledges();
        $pledgeAmounts      = $pledges->map(function ($pledge) {
            return $pledge->flatAmount();
        });

        while ($pledgeAmounts->count() > 0) {
            $this->assertEquals($pledgeAmounts->shift(), $expectedOrder->shift());
        }
    }
}
