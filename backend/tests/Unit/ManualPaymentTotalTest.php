<?php

namespace Tests\Unit;

use App\Entities\ManualPayment;
use App\Entities\Payment;
use App\Entities\PaymentsStudent;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ManualPaymentTotalTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function ManualPaymentTotal0()
    {
        $parentUser = User::where('email', 'parent@example.com')->first();
        $participant = $parentUser->participants()->first();
        $participant->participantManualPayments()->delete();
        $result = $this->actingAs($parentUser)
            ->get('/v3/api/participant/manualPaymentTotal/' . $participant->id);
        $result->assertJson(['total' => 0]);
    }

    /** @test */
    public function ManualPaymentTotal1Payment()
    {
        //having
        $parentUser = User::where('email', 'parent@example.com')->first();
        $participant = $parentUser->participants()->first();
        $participant->participantManualPayments()->delete();
        $payment = new Payment();
        $payment->amount = 100;
        $payment->save();
        $manualPayment = new ManualPayment([
            'payment_id'   => $payment->id,
            'entered_by'   => rand(1, 3),
            'type'         => 'cash',
            'check_number' => null,
            'classroom_id' => $participant->participantInfo->classroom->id,
        ]);
        $manualPayment->save();
        $paymentsStudent = new PaymentsStudent([
            'payment_id' => $payment->id,
            'student_id' => $participant->id,
            'amount' => 100,
            'add_to_envelope' => 1,
        ]);
        $paymentsStudent->save();

        //when
        $result = $this->actingAs($parentUser)
            ->get('/v3/api/participant/manualPaymentTotal/' . $participant->id);

        //then
        $result->assertJson(['total' => 100]);
    }
}
