<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Pledge;
use App\Entities\User;
use App\Http\Requests\PledgeRequest;
use App\Entities\BraintreeToken;
use App\Entities\OnlinePendingPayment;
use App\Entities\OnlinePendingPaymentPledge;

class EditPledgeDisabledFieldsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->parentUser         = User::where('email', 'parent@example.com')->first();
        $this->participantUser    = $this->parentUser->participants[0];
        $this->pledge             = factory(Pledge::class)->create([
            'user_id'             => $this->parentUser->id,
            'participant_user_id' => $this->participantUser->id,
            'pledge_status_id'    => Pledge::ENTERED_STATUS
        ]);

        $this->actingAs($this->parentUser);
    }

    /**
     * @return void
     */
    public function testSponsorCanEdit()
    {
        $result = PledgeRequest::canEditPledgeAmount($this->pledge->id);
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testNonSponsorCanEdit()
    {
        $otherUser           = User::where('email', '!=', 'parent@example.com')->first();
        $this->actingAs($otherUser);
        $result = PledgeRequest::canEditPledgeAmount($this->pledge->id);
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testPledgeIsPaid()
    {
        $this->pledge->pledge_status_id = Pledge::PAID_STATUS;
        $this->pledge->save();

        $result = PledgeRequest::canEditPledgeAmount($this->pledge->id);
        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testPledgeConfirmed()
    {
        $this->pledge->pledge_status_id = Pledge::CONFIRMED_STATUS;
        $this->pledge->save();

        $this->participantUser->laps = null;
        $this->participantUser->save();

        $result = PledgeRequest::canEditPledgeAmount($this->pledge->id);
        $this->assertTrue($result);

        $this->participantUser->laps = 1;
        $this->participantUser->save();

        $result = PledgeRequest::canEditPledgeAmount($this->pledge->id);
        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testNonSponsorWhenPaymentIsInScheduledState()
    {
        $otherUser = User::where('email', '!=', 'parent@example.com')->first();
        $this->actingAs($otherUser);

        $this->setUpPendingPayments();

        $result = PledgeRequest::canEditPledgeAmount($this->pledge->id);
        $this->assertFalse($result);
    }

    private function setUpPendingPayments()
    {
        $braintreeToken = BraintreeToken::inRandomOrder()->first();
        $tokenId    = $braintreeToken->id;
        $onlinePendingPayment       = factory(OnlinePendingPayment::class)->create([
            'bt_customer_id'                    => $braintreeToken->bt_customer_id,
            'bt_token_id'                       => $tokenId,
            'online_pending_payment_status_id'  => OnlinePendingPayment::STATUS_PENDING,
        ]);

        $onlinePendingPaymentPledge = factory(OnlinePendingPaymentPledge::class)->create([
            'online_pending_payments_id'    => $onlinePendingPayment->id,
            'pledge_id'                     => $this->pledge->id
        ]);
    }
}
