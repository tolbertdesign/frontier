<?php
namespace App\Mail;

use App\Entities\User;

class StudentStarVideoReadyEmail extends MailableWithOptout
{

    const EMAIL_TYPE_ID = 2;

    public $participantUser;
    public $parentUser;
    public $emailPreferencesUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $participantUser, User $parentUser, $emailPreferencesUrl)
    {
        $this->participantUser     = $participantUser;
        $this->parentUser          = $parentUser;
        $this->emailPreferencesUrl = $emailPreferencesUrl;
        $this->userEmailTypeId     = self::EMAIL_TYPE_ID;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.student_star_video_ready')
            ->subject($this->participantUser->first_name . '\'s Student Star video!')
            ->with(
                [
                    'participantShareLink' => $this->participantUser->shareLinkUrl(),
                    'programName'          => $this->participantUser->getProgram()->name,
                ]
            );
    }
}
