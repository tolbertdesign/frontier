<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Entities\User;
use App\Entities\Classroom;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use Exception;
use Illuminate\Support\Facades\Log;

class EditParticipantTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function setUp() : void
    {
        parent::setUp();

        Queue::fake();
        $this->parentUser       = User::where('email', 'parent@example.com')->first();
        $this->otherParentUser  = User::where('email', '!=', 'parent@example.com')->first();
        $this->participantUser  = $this->parentUser->participants[0];
    }

    public function testUpdating()
    {
        $classroomId = Classroom::inRandomOrder()->first()->id;

        $params = [
            'participant_id'          => $this->participantUser->id,
            'first_name'              => $this->faker->firstName(),
            'last_name'               => $this->faker->lastName(),
            'classroom_id'            => $classroomId,
            'pledge_goal'             => $this->faker->randomFloat(null, 0, 100),
            'pledge_page_text'        => 'Text',
            'family_pledging_enabled' => 0,
        ];

        $response = $this->actingAs($this->parentUser)
            ->post('/v3/participant/update', $params)
            ->assertStatus(200);

        $responseData = $response->getData();

        $this->assertTrue($responseData->first_name === $params['first_name']);
        $this->assertTrue($responseData->last_name === $params['last_name']);
        $this->assertTrue($responseData->participant_info->classroom_id === $params['classroom_id']);
        $this->assertEqualsWithDelta($responseData->profile->pledge_goal, $params['pledge_goal'], 0.01);
        $this->assertTrue($responseData->profile->pledge_page_text === $params['pledge_page_text']);
    }

    public function testUpdatingWithQueueExceptionThrown()
    {
        Queue::shouldReceive('dispatch')
            ->andThrow(new Exception());

        Log::shouldReceive('error')
            ->twice();

        $classroomId = Classroom::inRandomOrder()->first()->id;

        $params = [
            'participant_id'          => $this->participantUser->id,
            'first_name'              => $this->faker->firstName(),
            'last_name'               => $this->faker->lastName(),
            'classroom_id'            => $classroomId,
            'pledge_goal'             => $this->faker->randomFloat(null, 0, 100),
            'pledge_page_text'        => 'Text',
            'family_pledging_enabled' => 0,
        ];

        $this->actingAs($this->parentUser)
            ->post('/v3/participant/update', $params)
            ->assertStatus(200);
    }

    public function testNonParentUpdating()
    {
        $params = [
            'participant_id'   => $this->participantUser->id,
            'first_name'       => $this->faker->firstName(),
            'last_name'        => $this->faker->lastName(),
            'classroom_id'     => Classroom::inRandomOrder()->first()->id,
            'pledge_goal'      => $this->faker->randomFloat(null, 0, 100),
            'pledge_page_text' => 'Text',
        ];

        $this->actingAs($this->otherParentUser)
            ->post('/v3/participant/update', $params)
            ->assertStatus(302);
    }

    public function testUpdatingWithImage()
    {
        Storage::fake('s3');
        Config::set('booster.s3_user_profile_images', 'folder');

        $classroomId = Classroom::inRandomOrder()->first()->id;

        $params = [
            'participant_id'   => $this->participantUser->id,
            'first_name'       => $this->faker->firstName(),
            'last_name'        => $this->faker->lastName(),
            'classroom_id'     => $classroomId,
            'pledge_goal'      => $this->faker->randomFloat(null, 0, 100),
            'pledge_page_text' => 'Text',
            'photoFile'        => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $response = $this->actingAs($this->parentUser)
            ->post('/v3/participant/update', $params)
            ->assertStatus(200);

        $responseData = $response->getData();

        Storage::disk('s3')->assertExists(Config::get('booster.s3_user_profile_images') . $responseData->profile->image_name);

        unset($params['photoFile']);
        $params['deleteFile'] = 1;

        $response = $this->actingAs($this->parentUser)
            ->post('/v3/participant/update', $params)
            ->assertStatus(200);

        Storage::disk('s3')->assertMissing(Config::get('booster.s3_user_profile_images') . $responseData->profile->image_name);
    }
}
