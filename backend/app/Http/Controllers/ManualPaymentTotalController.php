<?php

namespace App\Http\Controllers;

use App\Entities\User;

class ManualPaymentTotalController extends Controller
{
    public function show(User $participantUser)
    {
        abort_unless($participantUser->isMyParticipant(), 401);

        return response()
            ->json(
                (object)[
                    'total'=> $participantUser->participantManualPaymentsTotal()
                ]
            );
    }
}
