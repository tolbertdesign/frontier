<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\Pledge;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\OnlinePendingPayment;

class ParentDeletePledgeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function canDeletePendingPledgeWithoutScheduledPaymentAsParent()
    {
        //having
        $user              = factory(User::class)->create();
        $participantUser   = factory(User::class)->create();
        $user->participants()->save($participantUser);
        $pledge = factory(Pledge::class)->create([
            'participant_user_id' => $participantUser->id,
            'pledge_status_id'    => Pledge::PENDING_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(200);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertEmpty($findPledge);
    }

    /** @test */
    public function canNotDeletePendingPledgeWithScheduledPaymentAsParent()
    {
        //having
        $user              = factory(User::class)->create();
        $participantUser   = factory(User::class)->create();
        $user->participants()->save($participantUser);
        $pledge = factory(Pledge::class)->create([
            'pledge_status_id' => Pledge::PENDING_STATUS
        ]);
        $onlinePendingPayment = factory(OnlinePendingPayment::class)->create([
            'deleted'        => 0,
            'bt_customer_id' => 1,
            'bt_token_id'    => 1
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
    public function canDeleteConfirmedPledgeWithoutLapsAsParent()
    {
        //having
        $user              = factory(User::class)->create();
        $participantUser   = factory(User::class)->create([
            'laps' => null
        ]);
        $user->participants()->save($participantUser);
        $pledge = factory(Pledge::class)->create([
            'participant_user_id' => $participantUser->id,
            'pledge_status_id'    => Pledge::CONFIRMED_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(200);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertEmpty($findPledge);
    }

    /** @test */
    public function canNotDeleteConfirmedPledgeWithLapsAsParent()
    {
        //having
        $user              = factory(User::class)->create();
        $participantUser   = factory(User::class)->create([
            'laps' => rand(0, 35)
        ]);
        $user->participants()->save($participantUser);
        $pledge = factory(Pledge::class)->create([
            'participant_user_id' => $participantUser->id,
            'pledge_status_id'    => Pledge::CONFIRMED_STATUS
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
    public function canDeletePaymentScheduledPledgeAsParent()
    {
        //having
        $user              = factory(User::class)->create();
        $participantUser   = factory(User::class)->create();
        $user->participants()->save($participantUser);
        $pledge = factory(Pledge::class)->create([
            'participant_user_id' => $participantUser->id,
            'pledge_status_id'    => Pledge::PAYMENT_SCHEDULED_STATUS
        ]);

        //when
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(200);

        //then
        $findPledge = Pledge::find($pledge->id);
        $this->assertEmpty($findPledge);
    }

    /** @test */
    public function canNotDeletePaidPledgeAsParent()
    {
        //having
        $user              = factory(User::class)->create();
        $participantUser   = factory(User::class)->create();
        $user->participants()->save($participantUser);
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
