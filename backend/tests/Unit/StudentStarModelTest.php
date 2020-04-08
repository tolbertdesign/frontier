<?php

namespace Tests\Unit;

use App\Entities\User;
use App\Models\StudentStarModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentStarModelTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreateJobWithMicrositeImage()
    {
        //having
        $mock = $this->getMockBuilder(StudentStarModel::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $participantImageEndpoint = 'https://s3.booster.com/myimageishere.png';
        $userId                   = 5;
        $eventName                = 'Great Event';
        $participantName          = 'Sally';
        $expectedData             = [
            'user_id'          => $userId,
            'school_name'      => $eventName,
            'participant_name' => $participantName,
            'callback_url'     => env('APP_URL') . '/api/hero_video',
            'image_endpoints'  => json_encode((object)[
                'kid'             => $participantImageEndpoint,
                'fundsRaisedFor1' => env('S3_BUCKET') . 'microsites/160927941_art_program.jpeg'
            ])
        ];

        //then
        $mock->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo('render_jobs'),
                $this->equalTo('POST'),
                $this->equalTo($expectedData)
            );

        //when
        $mock->createJob(
            $participantImageEndpoint,
            $userId,
            $participantName,
            $eventName
        );
    }

    public function testCreateJobWithoutMicrositeImage()
    {
        //having
        $mock = $this->getMockBuilder(StudentStarModel::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $participantImageEndpoint = 'https://s3.booster.com/myimageishere.png';
        $userId                   = 5;
        $eventName                = 'Great Event';
        $participantName          = 'Sally';
        $expectedData             = [
            'user_id'          => $userId,
            'school_name'      => $eventName,
            'participant_name' => $participantName,
            'callback_url'     => env('APP_URL') . '/api/hero_video',
            'image_endpoints'  => json_encode((object)[
                'kid'             => $participantImageEndpoint,
                'fundsRaisedFor1' => env('S3_BUCKET') . 'microsites/defaultFundsRaisedImage1.png'
            ])
        ];
        $microsite = User::find($userId)->getProgram()->microsite;
        $microsite->pic_1 = null;
        $microsite->pic_2 = null;
        $microsite->pic_3 = null;
        $microsite->save();

        //then
        $mock->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo('render_jobs'),
                $this->equalTo('POST'),
                $this->equalTo($expectedData)
            );

        //when
        $mock->createJob(
            $participantImageEndpoint,
            $userId,
            $participantName,
            $eventName
        );
    }
}
