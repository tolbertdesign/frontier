<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use App\Entities\User;
use App\Entities\Pledge;
use Illuminate\Support\Facades\Queue;
use App\Libraries\MercuryNotification;
use App\Entities\PledgeSponsor;
use App\Entities\PotentialSponsor;
use App\Http\Controllers\EasyEmailerController;
use App\Models\EasyEmailerModel;

class EasyEmailerControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $parentUser;
    private $participantUser;

    public function setUp() : void
    {
        parent::setUp();

        $this->parentUser      = User::where('email', 'parent@example.com')->first();
        $this->participantUser = $this->parentUser->participants[0];
        Mail::fake();
        Queue::fake();
    }

    /**
     * A basic test for adding a contact in the Easy Emailer
     *
     * @return  void
     */
    public function testEnrollContactsThatIsNotASponsor()
    {
        $contact                 = [];
        $contact['firstName']    = 'First Name';
        $contact['lastName']     = 'Last Name';
        $contact['emailAddress'] = 'test' . time() . '@example.com';

        $requestParameters                      = [];
        $requestParameters['contacts']          = [$contact];
        $requestParameters['participantUserId'] = $this->participantUser->id;

        $this->actingAs($this->parentUser)
            ->post('/v3/api/enroll-contacts', $requestParameters)
            ->assertJson([$contact]);
    }

    /**
     * A basic test for adding a contact in the Easy Emailer that is a sponsor
     *
     * @return  void
     */
    public function testEnrollContactsThatIsASponsor()
    {
        $contact                 = [];
        $contact['firstName']    = 'First Name';
        $contact['lastName']     = 'Last Name';
        $contact['emailAddress'] = User::first()->email;

        $requestParameters                      = [];
        $requestParameters['contacts']          = [$contact];
        $requestParameters['participantUserId'] = $this->participantUser->id;

        $this->actingAs($this->parentUser)
            ->post('/v3/api/enroll-contacts', $requestParameters)
            ->assertJson([$contact]);
    }

    public function testEmailingPreviousSponsor()
    {
        $sponsor = PledgeSponsor::inRandomOrder()->first();
        factory(Pledge::class)->create(
            [
                'participant_user_id' => $this->participantUser->id,
                'pledge_sponsor_id'   => $sponsor->id
            ]
        );

        $this->actingAs($this->parentUser)
            ->post(
                '/v3/api/previous-contact-enroll',
                [
                    'participantUserId' => $this->participantUser->id,
                    'sponsorIds'        => [$sponsor->id]
                ]
            );

        Queue::assertPushed(MercuryNotification::class, function ($job) use ($sponsor) {
            return $job->getRecipients()[0]->email === $sponsor->email;
        });
    }

    public function testEmailingPreviousSponsorNotParent()
    {
        $sponsor = PledgeSponsor::inRandomOrder()->first();
        factory(Pledge::class)->create(
            [
                'participant_user_id' => $this->participantUser->id,
                'pledge_sponsor_id'   => $sponsor->id
            ]
        );

        $invalidUser = User::where('email', '!=', 'parent@example.com')->first();

        $this->actingAs($invalidUser)
            ->post(
                '/v3/api/previous-contact-enroll',
                [
                    'participantUserId' => $this->participantUser->id,
                    'sponsorIds'        => [$sponsor->id]
                ]
            )
            ->assertStatus(302);
    }

    /**
     * @test
     *
     * @return void
     */
    public function deletePotentialSponsorAsParent()
    {
        $potentialSponsor = factory(PotentialSponsor::class)->create(
            [
                'deleted'             => 0,
                'participant_user_id' => $this->participantUser->id
            ]
        );
        $this->assertDatabaseHas(
            'potential_sponsors',
            [
                'deleted'             => 0,
                'email'               => $potentialSponsor->email,
                'participant_user_id' => $potentialSponsor->participant_user_id
            ]
        );

        $requestParameters = [
            'email'             => $potentialSponsor->email,
            'participantUserId' => $this->participantUser->id
        ];
        $this->actingAs($this->parentUser)
            ->post('/v3/api/delete-contact', $requestParameters)
            ->assertStatus(200);

        $this->assertDatabaseHas(
            'potential_sponsors',
            [
                'deleted'             => 1,
                'email'               => $potentialSponsor->email,
                'participant_user_id' => $potentialSponsor->participant_user_id
            ]
        );
    }

    /**
     * @test
     *
     * @return void
     */
    public function deletePreviousSponsorAsParent()
    {
        $user   = factory(User::class)->create();
        $pledge = factory(Pledge::class)->create(
            [
                'deleted'             => 0,
                'user_id'             => $user->id,
                'participant_user_id' => $this->participantUser->id
            ]
        );
        $this->assertDatabaseHas(
            'pledges',
            [
                'user_id'             => $user->id,
                'participant_user_id' => $pledge->participant_user_id
            ]
        );
        $this->assertDatabaseMissing(
            'potential_sponsors',
            [
                'email'               => $user->email,
                'participant_user_id' => $pledge->participant_user_id
            ]
        );

        $requestParameters = [
            'email'             => $user->email,
            'participantUserId' => $pledge->participant_user_id
        ];
        $this->actingAs($this->parentUser)
            ->post('/v3/api/delete-contact', $requestParameters)
            ->assertStatus(200);

        $this->assertDatabaseHas(
            'potential_sponsors',
            [
                'deleted'             => 1,
                'email'               => $user->email,
                'participant_user_id' => $pledge->participant_user_id
            ]
        );
    }
}
