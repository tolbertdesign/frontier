<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateEmailContactRequest;
use App\Http\Requests\ValidatePreviousSponsorSend;
use App\Models\EasyEmailerModel;
use App\Http\Response\Json as JsonResponse;
use App\Http\Response\Code;
use App\Entities\PledgeSponsor;
use App\Entities\PotentialSponsor;
use App\Http\Requests\DeleteContactRequest;
use Auth;

class EasyEmailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Enrolls contacts into Easy Emailer
     *
     * @param  App\Http\Requests\ValidateEmailContactRequest  $request
     * @return  void
     */
    public function enrollContacts(ValidateEmailContactRequest $request)
    {
        $validated        = $request->validated();
        $easyEmailerModel = new EasyEmailerModel($validated['participantUserId']);
        $enrolledContacts = $easyEmailerModel->enrollContacts($validated['contacts']);

        return response()->json($enrolledContacts);
    }

    /**
     * Send initial easy emailer email to the contact.
     *
     * @param  App\Http\Requests\ValidatePreviousSponsorSend  $request
     * @return  App\Http\Response\Json
     */
    public function sendToContact(ValidatePreviousSponsorSend $request)
    {
        $participantUserId = (int) $request->participantUserId;
        $participantUserIds = Auth::user()->participants->pluck('id')->toArray();

        $participantFilter = function ($query) use ($participantUserIds) {
            $query->whereIn('participant_user_id', $participantUserIds);
            $query->where('deleted', '=', 0)->orWhereNull('deleted');
        };

        $previousSponsors = PledgeSponsor::whereHas('pledges', $participantFilter)
            ->whereIn('id', $request->sponsorIds)->get();

        $easyEmailerModel = new EasyEmailerModel($participantUserId);
        $emailedResults = $easyEmailerModel->enrollPreviousSponsors($previousSponsors);

        if ($emailedResults) {
            return JsonResponse::asSuccess($emailedResults);
        } else {
            return JsonResponse::asError(Code::INTERNAL_ERROR);
        }
    }

    public function deleteContact(DeleteContactRequest $request)
    {
        PotentialSponsor::updateOrCreate(
            [
                'email'               => $request['email'],
                'participant_user_id' => $request['participantUserId'],
                'sender_user_id'      => Auth::id()
            ],
            [
                'deleted' => 1
            ]
        );
    }
}
