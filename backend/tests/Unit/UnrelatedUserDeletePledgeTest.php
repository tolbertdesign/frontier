<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Pledge;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\OnlinePendingPayment;

class UnrelatedUserDeletePledgeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function canNotDeletePendingPledgeWithScheduledPaymentAsUnrelatedUser()
    {
        //having
        $user   = factory(User::class)->create();
        $pledge = factory(Pledge::class)->create([
            'pledge_status_id' => Pledge::PENDING_STATUS
        ]);
        $onlinePendingPayment = factory(OnlinePendingPayment::class)->create([
            'deleted'=> 0,
            'bt_customer_id' => 1,
            'bt_token_id' => 1
        ]);
        $pledge->onlinePendingPayments()->save($onlinePendingPayment);
        $pledge->save();

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(403);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertNotEmpty($findPledge);
    }

    /** @test */
    public function canNotDeletePendingPledgeWithoutScheduledPaymentAsUnrelatedUser()
    {
        //having
        $user   = factory(User::class)->create();
        $pledge = factory(Pledge::class)->create([
            'pledge_status_id' => Pledge::PENDING_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(403);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertNotEmpty($findPledge);
    }

    /** @test */
    public function canNotDeleteConfirmedPledgeWithoutLapsAsUnrelatedUser()
    {
        //having
        $user   = factory(User::class)->create();
        $participantUser   = factory(User::class)->create([
            'laps' => null
        ]);
        $pledge = factory(Pledge::class)->create([
            'participant_user_id' => $participantUser->id,
            'pledge_status_id' => Pledge::CONFIRMED_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(403);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertNotEmpty($findPledge);
    }

    /** @test */
    public function canNotDeleteConfirmedPledgeWithLapsAsUnrelatedUser()
    {
        //having
        $user   = factory(User::class)->create();
        $participantUser   = factory(User::class)->create([
            'laps' => rand(0, 35)
        ]);
        $pledge = factory(Pledge::class)->create([
            'participant_user_id' => $participantUser->id,
            'pledge_status_id' => Pledge::CONFIRMED_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(403);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertNotEmpty($findPledge);
    }

    /** @test */
    public function canNotDeletePaymentScheduledPledgeAsUnrelatedUser()
    {
        //having
        $user   = factory(User::class)->create();
        $pledge = factory(Pledge::class)->create([
            'pledge_status_id' => Pledge::PAYMENT_SCHEDULED_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(403);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertNotEmpty($findPledge);
    }

    /** @test */
    public function canNotDeletePaidPledgeAsUnrelatedUser()
    {
        //having
        $user   = factory(User::class)->create();
        $pledge = factory(Pledge::class)->create([
            'pledge_status_id' => Pledge::PAID_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(403);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertNotEmpty($findPledge);
    }
}
