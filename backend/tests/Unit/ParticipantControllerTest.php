<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Entities\User;
use App\Entities\Classroom;
use App\Entities\Program;
use App\Models\RegisterModel;
use App\Entities\CharacterVideos;
use App\Http\Controllers\ParticipantController;
use App\Entities\Microsite;
use App\Entities\SponsorType;
use App\Entities\Pledge;
use App\Entities\ProgramVideos;
use Illuminate\Support\Facades\Queue;
use Mockery;

class ParticipantControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    private $parentUser;
    private $classroom;
    private $firstName;
    private $lastName;
    private $request;

    public function setUp() : void
    {
        parent::setUp();

        Queue::fake();
        $this->parentUser = User::find(4);
        $this->classroom  = Classroom::first();
        $this->firstName  = $this->faker->firstName();
        $this->lastName   = $this->faker->lastName();
        $this->request    = [
            'firstName'   => $this->firstName,
            'lastName'    => $this->lastName,
            'classroomId' => $this->classroom->id,
            'imageFile'   => null,
            'isAgreed'    => true,
        ];
    }

    /**
     * A test to successfully register a participant.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testParticipantRegisterSuccess()
    {
        Mail::fake();

        $this->actingAs($this->parentUser)
            ->post('/v3/register/participant', $this->request);

        $this->assertDatabaseHas('users', [
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'waiver_dob' => $this->parentUser->dob,
        ]);
    }

    /**
     * A test to try and register a participant but throw a school search exception.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testParticipantRegisterThrowSchoolSearchException()
    {
        Mail::fake();

        $mock = Mockery::mock('overload:' . RegisterModel::class);
        $mock->shouldReceive('searchSchoolByName')->andThrow(new Exception);

        $response = $this->actingAs($this->parentUser)
            ->post('/v3/register/participant', $this->request);

        $response->assertJsonFragment(['An error has ocurred, please try again.'])
            ->assertStatus(500);
    }

    /**
     * A test to try and register a participant but throw a mail exception.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testParticipantRegisterThrowMailException()
    {
        $mock = Mockery::mock('overload:' . Mail::class);
        $mock->shouldReceive('to')->andThrow(new Exception);

        $this->actingAs($this->parentUser)
            ->post('/v3/register/participant', $this->request)
            ->assertJsonFragment([
                'first_name'   => $this->firstName,
                'last_name'    => $this->lastName,
                'classroom_id' => $this->classroom->id,
            ]);
    }

    /**
     * A test to check the get pledge videos method
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testGetGetPledgesVideo()
    {
        $program       = Program::first();
        $programVideos = $program->microsite->getPledgesVideo();
        $response      = $this->actingAs($this->parentUser)
            ->get('/v3/api/videos/get-pledges/' . $program->id)
            ->assertJsonFragment([
                'id'                => $programVideos->id,
                'title'             => $programVideos->title,
                'description'       => $programVideos->description,
                'video_category_id' => $programVideos->video_category_id,
            ]);
    }

    /**
     * A test to check the get character videos method with a valid microsite
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testGetCharacterVideos()
    {
        $microsite = Microsite::where('hide_character_videos', null)->first();

        $characterVideosMock = $this->getMockBuilder(CharacterVideos::class)
            ->setMethods(['getVideos'])
            ->getMock();

        $characterVideosMock->expects($this->once())
            ->method('getVideos');

        if (! empty($microsite)) {
            $participantController = new ParticipantController($characterVideosMock);
            $participantController->getCharacterVideos($microsite->id);
        }
    }

    /**
     * A test to check the get character videos method on a program with hide character videos set
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testGetCharacterVideosWithHideCharacterVideosSet()
    {
        $invalidMicrositeId = 0;

        $characterVideos       = new CharacterVideos();
        $participantController = new ParticipantController($characterVideos);
        $characterVideos       = $participantController->getCharacterVideos($invalidMicrositeId);

        $this->assertEmpty($characterVideos);
    }

    /**
     * A test to check the get business leaderboard pledges
     *
     * @test
     * @return void
     */
    public function testGetBusinessLeaderboardPledges()
    {
        $sponsorType               = SponsorType::where('sponsor_type', 'Business')->first();
        $programId                 = $this->parentUser->participants[0]->getProgram()->id;
        $businessPledgesForProgram = Pledge::where('program_id', $programId)
            ->where('sponsor_type_id', $sponsorType->id)
            ->where('anon', 0)
            ->first();

        $this->actingAs($this->parentUser)
            ->get('/v3/api/business-leaderboard-pledges/' . $programId)
            ->assertJsonFragment([
                'business_name'    => $businessPledgesForProgram->business_name,
                'business_website' => $businessPledgesForProgram->business_website,
                'comment'          => $businessPledgesForProgram->comment
            ]);
    }

    /**
     * A test to check the get program videos
     *
     * @test
     * @return void
     */
    public function testGetProgramVideos()
    {
        $program = $this->parentUser->participants[0]->getProgram();
        Microsite::where('program_id', $program->id)->update([
            'intro_vid_override' => 1
        ]);

        $programVideos = new ProgramVideos($this->parentUser->participants);
        $videos        = $programVideos->getVideos();

        $this->actingAs($this->parentUser)
            ->get('/v3/api/videos/program/' . $this->parentUser->participants[0]->id)
            ->assertJsonFragment([
                'description'       => $videos[0]->description,
                'embed_uri'         => $videos[0]->embed_uri,
                'external_video_id' => $videos[0]->external_video_id
            ]);
    }

    /**
     * A test to try and update laps without being logged in as the participant's parent.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testUpdatingParticipantLapsWithoutAuthorization()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->put('/v3/api/users/' . $user->id, [
                'units' => 20
            ])
            ->assertStatus(302)
            ->assertRedirect('/v3');
    }

    /**
     * A test to update laps while being logged in as the participant's parent.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @return void
     */
    public function testUpdatingParticipantLapsWithAuthorization()
    {
        $participant           = $this->parentUser->participants[0];
        $laps                  = $participant->laps + 10;
        $participantInDatabase = User::find($participant->id);

        $this->assertNotSame($participantInDatabase->laps, $laps);

        $this->actingAs($this->parentUser)
            ->put('/v3/api/users/' . $participant->id, [
                'units' => $laps
            ])
            ->assertStatus(200);

        $participantInDatabase->refresh();
        $this->assertSame($participantInDatabase->laps, $laps);
    }
}
