<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Entities\PotentialSponsor;
use Illuminate\Support\Facades\Auth;
use App\Entities\User;
use App\Entities\UserActivity;
use App\Libraries\ProcessUserActivityRewards;
use App\Models\EmailModel;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class EasyEmailerModel extends EmailModel
{
    const DEFAULT_SPONSOR_USER_ID = 0;
    private $participantUserId;
    private $notificationName = 'PotentialSponsorEnrollment';

    public function __construct(int $participantUserId)
    {
        $this->participantUserId = $participantUserId;
    }

    /**
     * Returns the name of the notification.
     *
     * @return  String
     */
    protected function getNotificationName()
    {
        return $this->notificationName;
    }

    /**
     * Create a new PotentialSponsor.
     *
     * @param  String  $firstName
     * @param  String  $lastName
     * @param  String  $emailAddress
     *
     * @return  Boolean
     */
    public function createPotentialSponsor($firstName, $lastName, $emailAddress)
    {
        $sponsorUser            = User::where('email', $emailAddress)->first();
        $potentialSponsorUserId = $sponsorUser ? $sponsorUser->id : self::DEFAULT_SPONSOR_USER_ID;

        return PotentialSponsor::updateOrCreate(
            [
                'email'               => $emailAddress,
                'participant_user_id' => $this->participantUserId,
            ],
            [
                'first_name'          => $firstName,
                'last_name'           => $lastName,
                'sender_user_id'      => Auth::id(),
                'sponsor_user_id'     => $potentialSponsorUserId,
                'enrollment'          => 1,
                'deleted'             => 0
            ]
        );
    }

    /**
     * Enroll multiple contacts into the Easy Emailer and return the successful contacts.
     *
     * @param  Array  $contacts
     *
     * @return  Array
     */
    public function enrollContacts(array $contacts)
    {
        $successfulEntries = [];

        foreach ($contacts as $contact) {
            $isEnrolled = $this->enrollContact($contact);
            if ($isEnrolled) {
                $successfulEntries[] = $contact;
            };
        }
        return $successfulEntries;
    }

    /**
     * Enroll a contact into the Easy Emailer.
     *
     * @param  Array  $contact
     *
     * @return  Boolean
     */
    public function enrollContact(array $contact)
    {
        $potentialSponsor = $this->createPotentialSponsor($contact['firstName'], $contact['lastName'], $contact['emailAddress']);

        $user = User::make([
            'first_name' => $contact['firstName'],
            'last_name'  => $contact['lastName'],
            'email'      => $contact['emailAddress']
        ]);

        $this->sendEmail($user, $this->participantUserId);
        $this->updateUserActivitiesRewards();

        return $potentialSponsor;
    }

    /**
     * Get activity rewards for easy emailer.
     *
     * @return  void
     */
    public function updateUserActivitiesRewards()
    {
        $potentialSponsorCount = PotentialSponsor::where('participant_user_id', $this->participantUserId)
            ->where('enrollment', 1)
            ->count();

        $userActivities = UserActivity::where('category', UserActivity::EASY_EMAILER)
            ->where('amount_needed', '<=', $potentialSponsorCount)
            ->get();

        $participantUser = User::find($this->participantUserId);

        // Fire off job to award activity prizes
        ProcessUserActivityRewards::dispatch($participantUser, $userActivities);
    }

    /**
     * Enroll previous sponsors in the easy emailer system.
     *
     * @param  Collection  $previousSponsors
     *
     * @return  Array|Boolean
     */
    public function enrollPreviousSponsors(Collection $previousSponsors)
    {
        try {
            $emailedList = [];
            $skippedList = [];

            if (! empty($previousSponsors)) {
                foreach ($previousSponsors as $previousSponsor) {
                    $potentialSponsor = $this->createPotentialSponsor($previousSponsor->first_name, $previousSponsor->last_name, $previousSponsor->email);

                    $optedOutList = [$previousSponsor->hasOptedOut()];

                    if ($potentialSponsor) {
                        $optedOutList[] = $potentialSponsor->hasOptedOut();
                    }

                    $user = User::make([
                        'first_name' => $previousSponsor->first_name,
                        'last_name'  => $previousSponsor->last_name,
                        'email'      => $previousSponsor->email
                    ]);

                    if (!in_array(true, $optedOutList, true)) {
                        $this->sendEmail($user, $this->participantUserId);
                        $emailedList[] = $previousSponsor->id;
                    } else {
                        $skippedList[] = $previousSponsor->id;
                    }
                }

                $this->updateUserActivitiesRewards();
            }

            return [
                'emailed' => $emailedList,
                'skipped' => $skippedList
            ];
        } catch (Exception $e) {
            Log::error('There was an error enrolling previous sponsors.');
            Log::error($e);

            return false;
        }
    }
}
