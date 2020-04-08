<?php

namespace Tests\Unit;

use App\Entities\User;
use App\Entities\AccessToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A test to try and reset the password while logged in.
     *
     * @return void
     */
    public function testGettingClassPledgeUrl()
    {
        $teacher = User::where('email', 'teacher@example.com')->first();
        $teacherParticipant = $teacher->teacherParticipant();

        $response = $this->actingAs($teacher)
            ->get('/v3/api/report/class-pledge')
            ->assertStatus(200);

        $responseData = $response->getData();

        $expectedUrlPieces = [
            $teacher->id,
            $this->getLatestToken($teacher->id)->access_token,
            $teacherParticipant->getProgram()->id,
            $teacherParticipant->classroom->first()->id
        ];
        $expectedUrlSegment = implode('/', $expectedUrlPieces);

        $this->assertStringContainsString($expectedUrlSegment, $responseData->url);
    }

    private function getLatestToken($userId) {
        return AccessToken::where('user_id', $userId)
            ->orderBy('id', 'desc')->first();
    }
}
