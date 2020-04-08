<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Entities\Pledge;

class PledgeDeletionRequest extends FormRequest
{
    private $pledge;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! Auth::check()) {
            return false;
        }

        $pledgeId       = (int) $this->route('pledgeId');
        $this->pledge   = Pledge::find($pledgeId);

        if (! $this->pledge) {
            return false;
        }

        if ($this->isPaidPledge()) {
            return false;
        }

        if ($this->isConfirmedWithLaps()) {
            return false;
        }

        if ($this->isPendingAndIAmNotSponsor()) {
            return false;
        }

        if ($this->amNotTheSponsor() && $this->isNotMyParticipantsPledge()) {
            return false;
        }

        return true;
    }

    private function isPaidPledge()
    {
        return $this->pledge->pledge_status_id === Pledge::PAID_STATUS;
    }

    private function isConfirmedWithLaps()
    {
        return $this->pledge->pledge_status_id === Pledge::CONFIRMED_STATUS
            && $this->pledge->participantUser->laps !== null
            && $this->pledge->participantUser->laps !== '';
    }

    private function isPendingAndIAmNotSponsor()
    {
        return $this->pledge->pledge_status_id === Pledge::PENDING_STATUS
            && $this->pledge->hasPendingPayment
            && $this->amNotTheSponsor();
    }

    private function amNotTheSponsor()
    {
        return $this->pledge->user_id !== Auth::id();
    }

    private function isNotMyParticipantsPledge()
    {
        $myParticipantPledges = Auth::user()
            ->participants
            ->map(function ($participant) {
                return $participant->participantPledges;
            })->flatten()->map(
                function ($pledge) {
                    return $pledge['id'];
                }
            );
        return ! in_array($this->pledge->id, $myParticipantPledges->toArray());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
}
