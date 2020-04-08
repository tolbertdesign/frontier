<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Entities\UserEmailOptOut;
use App\Entities\User;

class MailableWithOptout extends Mailable
{

    use Queueable, SerializesModels;

    protected $userEmailTypeId;

    protected function buildRecipients($message)
    {
        foreach (['to', 'cc', 'bcc', 'replyTo'] as $type) {
            foreach ($this->{$type} as $recipient) {
                $userHasBlockedThisEmail = UserEmailOptOut::where('email', $recipient['address'])
                    ->where('user_email_type_id', $this->userEmailTypeId)
                    ->exists();

                $userHasOptedOutOfAllEmails = User::where('email', $recipient['address'])->value('email_opt_out');

                if (!$userHasBlockedThisEmail && !$userHasOptedOutOfAllEmails) {
                    $message->{$type}($recipient['address'], $recipient['name']);
                }
            }
        }

        return $this;
    }
}
