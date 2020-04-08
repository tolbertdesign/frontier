<?php

namespace Tests\Unit;

use App\Entities\Classroom;
use App\Entities\Participant;
use App\Entities\User;
use App\Entities\UserProfile;
use Tests\TestCase;
use App\Models\FamilyPledging;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FamilyPledgingTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test for shareImage method when the user has a profile image.
     *
     * @return void
     */
    public function testShareImageWithAProfileImageSet()
    {
        $imageName   = 'foo';
        $participant = factory(Participant::class)->create([
            'classroom_id' => Classroom::first()->id
        ]);
        $userProfile = factory(UserProfile::class)->create([
            'user_id'    => $participant->user_id,
            'image_name' => $imageName
        ]);
        $user         = User::with('profile')->where('id', $participant->user_id)->get();
        $profileImage = FamilyPledging::shareImage($user);

        $this->assertSame($profileImage, $userProfile->imageUrl());
    }

    /**
     * A test for shareImage method when the user doesn't have a profile image.
     *
     * @return void
     */
    public function testShareImageWithoutAProfileImageSet()
    {
        $imageName   = '';
        $classroom   = Classroom::first();
        $participant = factory(Participant::class)->create([
            'classroom_id' => $classroom->id
        ]);

        factory(UserProfile::class)->create([
            'user_id'    => $participant->user_id,
            'image_name' => $imageName
        ]);

        $user         = User::with('profile')->where('id', $participant->user_id)->get();
        $profileImage = FamilyPledging::shareImage($user);

        $this->assertSame($profileImage, $classroom->group->program->microsite->schoolImageUrl());
    }

    /**
     * A test for displayNames with one user
     *
     * @return void
     */
    public function testDisplayNamesWithOneUser()
    {
        $user1        = factory(User::class)->create();
        $users        = collect([$user1]);
        $displayNames = FamilyPledging::displayNames($users);

        $this->assertSame($displayNames, $user1->first_name);
    }

    /**
     * A test for displayNames with two users
     *
     * @return void
     */
    public function testDisplayNamesWithTwoUsers()
    {
        $user1        = factory(User::class)->create();
        $user2        = factory(User::class)->create();
        $users        = collect([$user1, $user2]);
        $displayNames = FamilyPledging::displayNames($users);

        $this->assertSame($displayNames, $user1->first_name . ' and ' . $user2->first_name);
    }

    /**
     * A test for displayNames with three users
     *
     * @return void
     */
    public function testDisplayNamesWithThreeUsers()
    {
        $user1        = factory(User::class)->create();
        $user2        = factory(User::class)->create();
        $user3        = factory(User::class)->create();
        $users        = collect([$user1, $user2, $user3]);
        $displayNames = FamilyPledging::displayNames($users);

        $this->assertSame($displayNames, $user1->first_name . ', ' . $user2->first_name . ' and ' . $user3->first_name);
    }

    /**
     * A test for checking if users have a video.
     *
     * @return void
     */
    public function testHasVideosWhenUsersDontHaveVideos()
    {
        $user1          = factory(User::class)->create();
        $user2          = factory(User::class)->create();
        $user3          = factory(User::class)->create();
        $users          = collect([$user1, $user2, $user3]);
        $familyPledging = new FamilyPledging();
        $response       = $familyPledging->hasVideo($users);

        $this->assertFalse($response);
    }

    /**
     * A test for checking if users have a video.
     *
     * @return void
     */
    public function testHasVideosWhenUsersHaveVideos()
    {
        $user1               = factory(User::class)->create();
        $user2               = factory(User::class)->create();
        $user3               = factory(User::class)->create();
        $userProfile1        = factory(UserProfile::class)->create([
            'user_id'   => $user1->id,
            'video_url' => 'test'
        ]);
        $userProfile2        = factory(UserProfile::class)->create([
            'user_id' => $user2->id,
            'video_url' => 'test'
        ]);
        $userProfile3        = factory(UserProfile::class)->create([
            'user_id' => $user3->id,
            'video_url' => 'test'
        ]);
        $user1->profile = $userProfile1;
        $user2->profile = $userProfile2;
        $user3->profile = $userProfile3;
        $users          = collect([$user1, $user2, $user3]);
        $familyPledging = new FamilyPledging();
        $response       = $familyPledging->hasVideo($users);

        $this->assertTrue($response);
    }
}
