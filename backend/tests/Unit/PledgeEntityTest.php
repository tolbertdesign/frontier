<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Pledge;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PledgeEntityTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test for checking the pay method.
     *
     * @return void
     */
    public function testPay()
    {
        $pledge = Pledge::where('pledge_status_id', '!=', Pledge::PAID_STATUS)->first();
        $pledge->pay($pledge->payment_id);

        $this->assertSame($pledge->pledge_status_id, Pledge::PAID_STATUS);
        $this->assertTrue($pledge->ts_completed > Carbon::yesterday());
        $this->assertTrue($pledge->ts_updated > Carbon::yesterday());
    }
}
