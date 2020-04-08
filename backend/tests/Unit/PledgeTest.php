<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Entities\Pledge;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\OnlinePendingPayment;
use App\Entities\OnlinePendingPaymentPledge;
use App\Entities\OnlinePendingPaymentStatus;
use App\Entities\StudentsParent;

class PledgeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function hasNoPendingPayment()
    {
        $pledge = $this->getPledgeNoOnlinePendingPayment();

        $this->assertFalse($pledge->hasPendingPayment);
    }

    /** @test */
    public function hasPendingPayment()
    {
        $pledge               = $this->getPledgeNoOnlinePendingPayment();
        $onlinePendingPayment = factory(OnlinePendingPayment::class)
            ->create(
                [
                    'bt_customer_id' => 1,
                    'bt_token_id'    => 1,
                    'deleted'        => 0
                ]
            );
        $pledge->onlinePendingPayments()->attach($onlinePendingPayment);
        $pledge->save();

        $this->assertTrue($pledge->hasPendingPayment);
    }

    /** @test */
    public function hasDeletedPendingPayment()
    {
        $pledge               = $this->getPledgeNoOnlinePendingPayment();
        $onlinePendingPayment = factory(OnlinePendingPayment::class)
            ->create(
                [
                    'bt_customer_id' => 1,
                    'bt_token_id'    => 1,
                    'deleted'        => 1
                ]
            );
        $pledge->onlinePendingPayments()->attach($onlinePendingPayment);
        $pledge->save();

        $this->assertFalse($pledge->hasPendingPayment);
    }

    /* @test */
    public function canEditPledge()
    {
        $pledge         = $this->getPledgeNoOnlinePendingPayment();
        $parent         = $pledge->particpant->parents->first();
        $editUrl        = '/v3/pledges/edit/' . $pledge->id;
        $pledge->amount = 3;
        $this->as($parent)->json('post', $editUrl, $pledge->toArray());
        $pledge->refresh();
        $this->assertTrue($pledge->amount === 3);
    }

    /** @test */
    public function testDeletePledgeWithAnyPledgeStatus()
    {
        $pledgeStatuses        = range(1, 8);
        $studentParent         = factory(StudentsParent::class)->create();
        $parentUser            = User::find($studentParent->parent_id);
        $participantUser       = User::find($studentParent->student_id);
        $participantUser->laps = 30;
        $participantUser->save();
        $otherUser             = User::where('id', '!=', $parentUser->id)->first();

        foreach ($pledgeStatuses as $status) {
            $pledge = factory(Pledge::class)->create([
                'participant_user_id' => $participantUser->id,
                'pledge_status_id'    => $status,
                'user_id'             => $otherUser->id,
            ]);

            $findPledge = Pledge::find($pledge->id);
            $this->assertNotEmpty($findPledge);

            $onlinePendingPaymentPledge = OnlinePendingPaymentPledge::first();
            if (! $onlinePendingPaymentPledge) {
                $this->assertTrue(false);
            }

            OnlinePendingPaymentPledge::where('online_pending_payments_id', $onlinePendingPaymentPledge->online_pending_payments_id)->update([
                'pledge_id' => $findPledge->id
            ]);

            $acceptableStatuses                                     = OnlinePendingPaymentStatus::where('name', '!=', 'Denied')->first();
            $onlinePendingPayment                                   = OnlinePendingPayment::where('id', $onlinePendingPaymentPledge->online_pending_payments_id)->first();
            $onlinePendingPayment->deleted                          = 0;
            $onlinePendingPayment->online_pending_payment_status_id = $acceptableStatuses->id;
            $onlinePendingPayment->save();

            if ($findPledge->pledge_status_id === Pledge::PAID_STATUS) {
                $this->deletePledgeFails($findPledge, $parentUser);
            } elseif ($findPledge->pledge_status_id === Pledge::CONFIRMED_STATUS && $findPledge->participantUser->laps !== null && $findPledge->participantUser->laps !== '') {
                $this->deletePledgeFails($findPledge, $parentUser);
            } elseif ($findPledge->pledge_status_id === Pledge::PENDING_STATUS && $findPledge->hasPendingPayment && $findPledge->user_id !== $parentUser->id) {
                $this->deletePledgeFails($findPledge, $parentUser);
            } else {
                if (in_array($findPledge->pledge_status_id, [1, 5, 6, 7])) { //unused statuses
                    continue;
                }
                $this->deletePledgeSuccess($findPledge, $parentUser);
            }
        }
    }

    private function deletePledgeFails($pledge, $user)
    {
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(403);

        $findPledge = Pledge::find($pledge->id);
        $this->assertNotEmpty($findPledge);
    }

    private function deletePledgeSuccess($pledge, $user)
    {
        $this->actingAs($user)
            ->json('delete', '/v3/pledges/' . $pledge->id)
            ->assertStatus(200);

        $findPledge = Pledge::find($pledge->id);
        $this->assertEmpty($findPledge);
    }

    private function getPledgeNoOnlinePendingPayment()
    {
        $pledge = Pledge::first();
        $pledge->onlinePendingPayments()->detach();
        $pledge->save();
        return $pledge;
    }

    /* @test */
    public function testEditPledgeWithoutFamilyPledgingId()
    {
        $participantUser = factory(User::class)->create();
        $user            = factory(User::class)->create();
        StudentsParent::insert([
            'student_id' => $participantUser->id,
            'parent_id'  => $user->id
        ]);

        $pledge          = factory(Pledge::class)->create([
            'pledge_status_id'    => Pledge::ENTERED_STATUS,
            'family_pledge_id'    => null,
            'participant_user_id' => $participantUser->id
        ]);

        $amount = $pledge->amount + 1;

        $this->actingAs($pledge->participantUser->parents()->first())
            ->put('/v3/pledges/edit/' . $pledge->id, [
                'pledge' => [
                    'pledge_sponsor' => [
                        'first_name' => 'first',
                        'last_name'  => 'last',
                        'email'      => 'test@example.com',
                        'phone'      => 1234567890,
                        'state'      => 'GA',
                        'country'    => 'US',
                    ],
                    'amount'            => $amount,
                    'pledge_type_id'    => 1,
                    'sponsor_type_id'   => 1
                ]
            ])
            ->assertStatus(200);

        $pledge->refresh();
        $this->assertEquals($pledge->amount, $amount);
    }

    /* @test */
    public function testEditPledgeWithFamilyPledgingId()
    {
        $participantUser = factory(User::class)->create();
        $user            = factory(User::class)->create();
        StudentsParent::insert([
            'student_id' => $participantUser->id,
            'parent_id'  => $user->id
        ]);

        $pledge          = factory(Pledge::class)->create([
            'pledge_status_id'    => Pledge::ENTERED_STATUS,
            'family_pledge_id'    => 12345,
            'participant_user_id' => $participantUser->id
        ]);


        $amount = $pledge->amount + 1;

        $this->actingAs($pledge->participantUser->parents()->first())
            ->put('/v3/pledges/edit/' . $pledge->id, [
                'pledge' => [
                    'pledge_sponsor' => [
                        'first_name' => 'first',
                        'last_name'  => 'last',
                        'email'      => 'test@example.com',
                        'phone'      => 1234567890,
                        'state'      => 'GA',
                        'country'    => 'US',
                    ],
                    'amount'            => $amount,
                    'pledge_type_id'    => 1,
                    'sponsor_type_id'   => 1,
                    'family_pledge_id'  => 12345
                ]
            ])
            ->assertStatus(200);

        $pledge->refresh();
        $this->assertEquals($pledge->amount, $amount);
    }
}
