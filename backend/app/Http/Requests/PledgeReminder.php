<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Entities\Pledge;
use App\Entities\User;

class PledgeReminder extends FormRequest
{
    private $sponsorEmail;
    private $sponsorFirstName;
    private $participantFirstName;
    private $eventName;
    private $frCode;
    private $parentFirstName;

    /**
     * Determine if the user is authorized to make this request.
     * The user can send a reminder about a pledge if:
     * 1) they are a parent w/ a child in that pledge
     * 2) the pledge is in an unpaid state
     *
     * @return bool
     */
    public function authorize()
    {
        $currentUserId = Auth::id();
        $recordObj = Pledge::getDataForReminderEmail((int) $this->route('pledgeId'), $currentUserId);

        if ($recordObj && !empty($recordObj)) {
            $user = User::find($currentUserId);

            $this->sponsorEmail = $recordObj->sponsorEmail;
            $this->sponsorFirstName = $recordObj->sponsorFirstName;
            $this->participantFirstName = $recordObj->participantFirstName;
            $this->parentFirstName = $user->first_name;
            $this->eventName = $recordObj->eventName;
            $this->frCode = $recordObj->fr_code;

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function getSponsorEmail(): string
    {
        return $this->sponsorEmail;
    }

    public function getSponsorFirstName(): string
    {
        return $this->sponsorFirstName;
    }

    public function getParticipantFirstName(): string
    {
        return $this->participantFirstName;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getFrCode(): string
    {
        return $this->frCode;
    }

    public function getParentFirstName(): string
    {
        return $this->parentFirstName;
    }
}
