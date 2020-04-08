<?php

namespace App\Http\Controllers;

use App\Http\Response\Json as Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\PledgeReminder;
use App\Http\Requests\PledgeReminder as ReminderRequest;
use App\Entities\Pledge;
use App\Http\Requests\PledgeRequest;
use App\Http\Requests\PledgeDeletionRequest;

class PledgeController extends Controller
{
    const REMINDER_SURVEY_LINK = 'https://funrunsponsorsurvey.typeform.com/to/lABXeS';

    public function reminder(ReminderRequest $request)
    {
        $dataForEmail = [
            'sponsorFirstName'  => $request->getSponsorFirstName(),
            'participantName'   => $request->getParticipantFirstName(),
            'eventName'         => $request->getEventName(),
            'parentFirstName'   => $request->getParentFirstName(),
            'payLink'           => Pledge::makeTkPayLink($request->getFrCode()),
            'surveyLink'        => self::REMINDER_SURVEY_LINK
        ];

        Mail::to($request->getSponsorEmail())->send(new PledgeReminder($dataForEmail));

        return Response::asSuccess();
    }

    public function update(PledgeRequest $request, Pledge $pledge)
    {
        $this->authorize('update', $pledge);
        $validatedData = $request->validated();
        $pledgeUpdate  = $validatedData['pledge'];

        $pledgeData = [
            'sponsor_type_id' => $pledgeUpdate['sponsor_type_id'],
        ];

        if (array_key_exists('amount', $pledgeUpdate)) {
            $pledgeData['amount'] = $pledgeUpdate['amount'];
        }

        if (array_key_exists('pledge_type_id', $pledgeUpdate)) {
            $pledgeData['pledge_type_id'] = $pledgeUpdate['pledge_type_id'];
        }

        if ($pledge->family_pledge_id) {
            Pledge::where('family_pledge_id', $pledge->family_pledge_id)
                ->update($pledgeData);
            $pledges = Pledge::where('family_pledge_id', $pledge->family_pledge_id)->get();
        } else {
            Pledge::where('id', $pledge->id)
                ->update($pledgeData);
            $pledges = Pledge::where('id', $pledge->id)->get();
        }

        $pledges->each(function ($updatedPledge) use ($pledgeUpdate) {
            $sponsor = $updatedPledge->pledgeSponsor;
            $sponsor->first_name = $pledgeUpdate['pledge_sponsor']['first_name'];
            $sponsor->last_name = $pledgeUpdate['pledge_sponsor']['last_name'];
            $sponsor->email = $pledgeUpdate['pledge_sponsor']['email'];
            $sponsor->phone = $pledgeUpdate['pledge_sponsor']['phone'];
            $sponsor->state      = $sponsor->country !== 'US' ? '' : $pledgeUpdate['pledge_sponsor']['state'];
            $sponsor->country = $pledgeUpdate['pledge_sponsor']['country'];
            $sponsor->save();
        });

        return $pledges->load(['participantUser', 'pledgeSponsor']);
    }

    public function delete(PledgeDeletionRequest $request, $pledgeId)
    {
        return Pledge::find($pledgeId)->setPledgeToDeleted();
    }
}
