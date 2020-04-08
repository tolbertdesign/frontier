<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Entities\User;
use App\Libraries\MercuryNotification;

abstract class EmailModel
{
    abstract protected function getNotificationName();

    /**
     * Dispatch job to send an email to a contact.
     *
     * @param  User  $user
     * @param  Integer  $participantUserId
     *
     * @return  void
     */
    public function sendEmail(User $user, $participantUserId)
    {
        $participantUser = User::find($participantUserId);

        $notification = new MercuryNotification($participantUser, $this->getNotificationName());
        $notification->addRecipient($user);
        dispatch($notification);
    }
}
