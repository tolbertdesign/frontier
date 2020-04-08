<?php

namespace Tests\Unit;

use App\Entities\PotentialSponsor;
use App\Entities\User;
use App\Entities\PledgeSponsor;
use App\Libraries\ProcessUserActivityRewards;
use App\Models\EasyEmailerModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class EasyEmailerModelTest extends TestCase
{
    use DatabaseTransactions;

    private $parentUser;
    private $participantUser;
    private $numberOfIterations;

    public function setUp() : void
    {
        parent::setUp();
        Queue::fake();
        $this->parentUser         = User::find(4);
        $this->participantUser    = $this->parentUser->participants[0];
        $this->numberOfIterations = 2;
    }

    /**
     * A test for the exception when enrolling previous sponsors.
     *
     * @return void
     */
    public function testReceivingFalseWhenExceptionThrownForEnrollPreviousSponsorsMethod()
    {
        $previousSponsors       = User::limit(3)->get();
        $easyEmailerModel       = new EasyEmailerModel($this->participantUser->id);
        $enrollPreviousSponsors = $easyEmailerModel->enrollPreviousSponsors($previousSponsors);

        $this->assertFalse($enrollPreviousSponsors);
    }

    /**
     * A test for sending the notification off to the queue.
     *
     * @return void
     */
    public function testSendUserActivityRewardToQueue()
    {
        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $easyEmailerModel->updateUserActivitiesRewards();

        Queue::assertPushed(ProcessUserActivityRewards::class);
    }

    /**
     * A test for creating a potential sponsor.
     *
     * @return void
     */
    public function testCreatePotentialSponsor()
    {
        $this->actingAs($this->parentUser);
        $user = factory(User::class)->make();

        $this->assertDatabaseMissing('potential_sponsors', ['email' => $user->email]);

        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $easyEmailerModel->createPotentialSponsor($user->first_name, $user->last_name, $user->email);

        $this->assertDatabaseHas('potential_sponsors', [
            'email'           => $user->email,
            'sponsor_user_id' => EasyEmailerModel::DEFAULT_SPONSOR_USER_ID
        ]);
    }

    /**
     * A test for creating a potential sponsor that already exists.
     *
     * @return void
     */
    public function testTryToCreatePotentialSponsorThatAlreadyExists()
    {
        $this->actingAs($this->parentUser);
        $this->assertDatabaseMissing('potential_sponsors', ['email' => $this->parentUser->email]);

        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $easyEmailerModel->createPotentialSponsor($this->parentUser->first_name, $this->parentUser->last_name, $this->parentUser->email);
        $easyEmailerModel->createPotentialSponsor($this->parentUser->first_name, $this->parentUser->last_name, $this->parentUser->email);

        $this->assertDatabaseHas('potential_sponsors', [
            'email'               => $this->parentUser->email,
            'participant_user_id' => $this->participantUser->id,
            'deleted'             => 0
        ]);
        $potentialSponsorCount = PotentialSponsor::where('email', $this->parentUser->email)
            ->where('participant_user_id', $this->participantUser->id)
            ->count();

        $this->assertEquals(1, $potentialSponsorCount);
    }

    /**
     * A test for restoring a potential sponsor that already exists but is deleted.
     *
     * @return void
     */
    public function testRestorePotentialSponsorThatAlreadyExistsButIsDeleted()
    {
        $this->actingAs($this->parentUser);
        $this->assertDatabaseMissing('potential_sponsors', ['email' => $this->parentUser->email]);

        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $easyEmailerModel->createPotentialSponsor($this->parentUser->first_name, $this->parentUser->last_name, $this->parentUser->email);

        // Delete potential sponsor
        PotentialSponsor::where('email', $this->parentUser->email)
            ->where('participant_user_id', $this->participantUser->id)
            ->update([
                'deleted' => 1
            ]);

        // Update the potential sponsor
        $easyEmailerModel->createPotentialSponsor($this->parentUser->first_name, $this->parentUser->last_name, $this->parentUser->email);

        $this->assertDatabaseHas('potential_sponsors', [
            'email'               => $this->parentUser->email,
            'participant_user_id' => $this->participantUser->id,
            'deleted'             => 0
        ]);

        $potentialSponsorCount = PotentialSponsor::where('email', $this->parentUser->email)
            ->where('participant_user_id', $this->participantUser->id)
            ->count();

        $this->assertEquals(1, $potentialSponsorCount);
    }

    /**
     * A test for enrolling a contact while being logged in as a user.
     *
     * @return void
     */
    public function testEnrollingAContact()
    {
        $this->actingAs($this->parentUser);
        $email   = 'emailAddress@example.test';
        $contact = [
            'firstName'    => 'firstName',
            'lastName'     => 'lastName',
            'emailAddress' => $email,
        ];

        // Ensure that values aren't already in database
        $this->assertDatabaseMissing('potential_sponsors', ['email' => $email]);

        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $potentialSponsor = $easyEmailerModel->enrollContact($contact);

        $this->assertIsObject($potentialSponsor);
        $this->assertSame($email, $potentialSponsor->email);
        $this->assertDatabaseHas('potential_sponsors', ['email' => $email]);
    }

    /**
     * A test for enrolling contacts while being logged in as a user.
     *
     * @return void
     */
    public function testEnrollingContacts()
    {
        $this->actingAs($this->parentUser);

        // Create contacts array
        $contacts = [];
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $contacts[] = [
                'firstName'    => 'firstName' . $i,
                'lastName'     => 'lastName' . $i,
                'emailAddress' => 'emailAddress' . $i . '@example.test',
            ];
        }

        // Ensure that values aren't already in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseMissing('potential_sponsors', ['email' => $contacts[$i]['emailAddress']]);
        }

        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $returnedContacts = $easyEmailerModel->enrollContacts($contacts);

        // Ensure that values are in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseHas('potential_sponsors', ['email' => $contacts[$i]['emailAddress']]);
        }

        $this->assertSame($returnedContacts, $contacts);
    }

    /**
     * A test for enrolling previous sponsors while being logged in as a user.
     *
     * @return void
     */
    public function testEnrollingPreviousSponsors()
    {
        $this->actingAs($this->parentUser);
        $users = $this->getUserCollection();

        // Ensure that values aren't already in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseMissing('potential_sponsors', ['email' => $users[$i]->email]);
        }

        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $response         = $easyEmailerModel->enrollPreviousSponsors($users);

        // Ensure that values are in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseHas('potential_sponsors', ['email' => $users[$i]->email]);
        }

        $this->assertTrue(count($response) > 0);
        Queue::assertPushed(ProcessUserActivityRewards::class);
    }

    /**
     * A test for enrolling previous sponsors without being logged in as a user.
     *
     * @return void
     */
    public function testEnrollingPreviousSponsorsWithoutBeingLoggedIn()
    {
        Log::shouldReceive('error')->twice();
        $users = $this->getUserCollection();

        // Ensure that values aren't already in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseMissing('potential_sponsors', ['email' => $users[$i]->email]);
        }

        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $response         = $easyEmailerModel->enrollPreviousSponsors($users);

        // Ensure that values still aren't in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseMissing('potential_sponsors', ['email' => $users[$i]->email]);
        }

        $this->assertFalse($response);
        Queue::assertNotPushed(ProcessUserActivityRewards::class);
    }

    /**
     * A test for enrolling previous sponsors that already exist.
     *
     * @return void
     */
    public function testEnrollingPreviousSponsorsThatAlreadyExist()
    {
        $this->actingAs($this->parentUser);
        $users = $this->getUserCollection();

        // Ensure that values aren't already in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseMissing('potential_sponsors', ['email' => $users[$i]->email]);
        }

        // Enroll the users as previous sponsors
        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $response         = $easyEmailerModel->enrollPreviousSponsors($users);

        // Ensure that values are in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseHas('potential_sponsors', ['email' => $users[$i]->email]);
        }

        $this->assertTrue(count($response) > 0);

        // Rerun the same users (which have already been added)
        $this->actingAs($this->parentUser);
        $easyEmailerModel = new EasyEmailerModel($this->participantUser->id);
        $response         = $easyEmailerModel->enrollPreviousSponsors($users);

        // Ensure that values are in database
        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $this->assertDatabaseHas('potential_sponsors', ['email' => $users[$i]->email]);
        }

        // Even though the users already exist, this should still be successful and return true
        $this->assertTrue(count($response) > 0);
        Queue::assertPushed(ProcessUserActivityRewards::class);
    }

    /**
     * Create a collection of users.
     *
     * @return  Collection
     */
    public function getUserCollection()
    {
        $users = [];

        for ($i = 0; $i < $this->numberOfIterations; $i++) {
            $users[] = factory(PledgeSponsor::class)->make();
        }

        return Collection::make($users);
    }
}
