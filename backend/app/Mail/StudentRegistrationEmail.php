<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use App\Entities\User;
use App\Entities\AdLocation;
use App\Entities\ProgramSponsorAd;

class StudentRegistrationEmail extends MailableWithOptout implements ShouldQueue
{
    const EMAIL_TYPE_ID = 2;

    use Queueable, SerializesModels;

    private $user;
    private $url;
    private $parent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $url, User $parent)
    {
        $this->user                = $user;
        $this->url                 = $url;
        $this->parent              = $parent;
        $this->userEmailTypeId     = self::EMAIL_TYPE_ID;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $previousPledges = $this->user->previousPledges();
        $adLocation      = AdLocation::where('location', 'register_participant_welcome_email')->first();
        $ads             = $this->user->getAds($adLocation);
        $adText          = '';
        $baseUrl         = 'https://' . $this->url . '/';
        foreach ($ads as $ad) {
            $adText .= ProgramSponsorAd::processAdText(
                $ad,
                ['BASE_URL'                         => $baseUrl,
                    'PROGRAM_SPONSOR_AD_LOCATION_ID'=> 'register_participant_welcome_email'
                ]
            );
            $adText .= '<br />';
        }

        return $this->from(config('mail.from.address'), $this->user->getProgram()->event_name)
            ->view('emails.student_registered')
            ->with([
                'user'            => $this->user,
                'previousPledges' => $previousPledges,
                'url'             => $this->url,
                'parent'          => $this->parent,
                'adText'          => $adText])
            ->subject($this->user->first_name . ' is registered on ' . $this->user->getProgram()->unit->domain);
    }
}
