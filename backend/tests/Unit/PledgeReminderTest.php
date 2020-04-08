<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use App\Entities\StudentsParent;
use App\Entities\Pledge;
use App\Entities\PledgeType;
use App\Entities\User;
use App\Mail\PledgeReminder as PledgeReminderMailable;

class PledgeReminderTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();

        // Create fake pledge & make sure it is in an unpaid status
        $this->pledge = factory(Pledge::class)->create([
            'pledge_status_id' => Pledge::CONFIRMED_STATUS,
            'pledge_type_id'   => PledgeType::FLAT
        ]);

        factory(StudentsParent::class)->create(
            ['student_id' => $this->pledge->participant_user_id,
            'parent_id' => factory(User::class)->create()->id]
        );
    }

    /**
     * Test that another parent can't submit a reminder for another parent
     */
    public function testParentCantSendReminderWithAnotherParentId()
    {
        $parentId = StudentsParent::where('student_id', '=', $this->pledge->participant_user_id)->value('parent_id');
        $otherParentId = StudentsParent::where('parent_id', '!=', $parentId)->value('parent_id');

        $recordObj = Pledge::getDataForReminderEmail($this->pledge->id, $otherParentId);
        $this->assertFalse( ($recordObj && !empty($recordObj) ? true : false) );
    }

    /**
     * Test that successful reminder can be retrieved
     */
    public function testReminderForUnpaidPledge()
    {
        // Get parent of the student of the pledge
        $parentId = StudentsParent::where('student_id', '=', $this->pledge->participant_user_id)->value('parent_id');

        $recordObj = Pledge::getDataForReminderEmail($this->pledge->id, $parentId);
        $this->assertTrue( ($recordObj && !empty($recordObj) ? true : false) );
    }

    /**
     * Test that paid reminder will not be retrieved
     */
    public function testReminderForPaidPledge()
    {
        $pledge = Pledge::find($this->pledge->id);
        $pledge->payment_id = null;
        $pledge->save();

        $parentId = StudentsParent::where('student_id', '=', $this->pledge->participant_user_id)->value('parent_id');

        $recordObj = Pledge::getDataForReminderEmail($this->pledge->id, $parentId);
        $this->assertFalse( ($recordObj && !empty($recordObj) ? true : false) );
    }

    /**
     * Test that mail will be sent when reminder request is sent
     */
    public function testMailIsSent()
    {
        Mail::fake();

        $parentId = StudentsParent::where('student_id', '=', $this->pledge->participant_user_id)->value('parent_id');
        $parentUser = User::find($parentId);

        $this->actingAs($parentUser, 'web')
            ->post('/v3/pledge/reminder/' . $this->pledge->id);

        Mail::assertSent(PledgeReminderMailable::class, 1);
    }
}
