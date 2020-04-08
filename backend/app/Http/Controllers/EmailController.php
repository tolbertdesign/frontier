<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentStarVideoReadyEmail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function studentStarVideoReady(Request $request)
    {
        $validatedData = $request->validate([
            'id_participant' => 'required|integer',
        ]);

        $userId          = $request->input('id_participant');
        $participantUser = User::findOrFail($userId);
        $parentUsers     = $participantUser->parents;
        foreach ($parentUsers as $parentUser) {
            $emailPreferencesUrl = url('v3/email-preferences/' . $parentUser->getEmailPreferenceToken());
            Mail::to($parentUser->email)
            ->send(
                new StudentStarVideoReadyEmail($participantUser, $parentUser, $emailPreferencesUrl)
            );
        }
    }
}
