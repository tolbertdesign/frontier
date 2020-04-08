<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Entities\Pledge;
use App\Entities\OnlinePendingPayment;

class PledgeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $pledge = $this->route('pledge');
        return $pledge->participantUser->parents()->get()->pluck('id')->contains(Auth::user()->id);
    }

    public static function canEditPledgeAmount(int $pledgeId)
    {
        $pledge = Pledge::find($pledgeId);

        if ($pledge->pledge_status_id === Pledge::PAID_STATUS) {
            // Can't edit once the pledge has been paid
            return false;
        }

        if ($pledge->pledge_status_id === Pledge::CONFIRMED_STATUS && $pledge->participantUser->hasLapsEntered()) {
            // Can't edit once the pledge has been confirmed
            return false;
        }

        if ($pledge->user_id === Auth::id()) {
            // If I am the sponsor of this pledge, then I can always edit the amount
            return true;
        }

        $onlinePendingPayments = $pledge->onlinePendingPayments;

        if ($onlinePendingPayments->isEmpty()) {
            // No pending payments, so user can edit
            return true;
        }

        // Make sure no payment is currently in a scheduled state
        $hasPaymentInAScheduledState = false;

        foreach ($onlinePendingPayments as $onlinePendingPayment) {
            if (in_array($onlinePendingPayment->online_pending_payment_status_id, OnlinePendingPayment::$statusPaymentScheduled)) {
                $hasPaymentInAScheduledState = true;
                break;
            }
        }

        if ($hasPaymentInAScheduledState) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pledge = $this->route('pledge');

        $fieldsToExpect = [
            'pledge.pledge_sponsor.first_name' => 'required|string',
            'pledge.pledge_sponsor.last_name' => 'required|string',
            'pledge.pledge_sponsor.email' => 'required|string|email',
            'pledge.pledge_sponsor.phone' => 'required|numeric|digits:10',
            'pledge.pledge_sponsor.state' => 'required|string|max:2',
            'pledge.pledge_sponsor.country' => 'required|string',
            'pledge.amount' => 'required|numeric',
            'pledge.pledge_type_id' => 'required|numeric',
            'pledge.sponsor_type_id' => 'required|numeric'
        ];

        if (!self::canEditPledgeAmount($pledge->id)) {
            unset($fieldsToExpect['pledge.amount'], $fieldsToExpect['pledge.pledge_type_id']);
        }

        return $fieldsToExpect;
    }
}
