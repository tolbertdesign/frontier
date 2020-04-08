<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Entities\SponsorType;
use App\Entities\Pledge;
use App\Entities\Program;
use App\Entities\User;
use App\Entities\PledgeType;
use App\Models\BusinessLeaderboard;


class BusinessLeaderboardTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function setUp() : void
    {
        parent::setUp();

        $programCreate    = factory(Program::class)->create();
        $this->program    = Program::where('id', $programCreate->id)->first();
        $this->businessPledgeTypeId = SponsorType::where('sponsor_type', 'Business')->first()->id;
    }

    public function testOrderIsCorrect()
    {
        // Flat
        $flatAmount = 4;
        factory(Pledge::class)->create([
            'sponsor_type_id'   => $this->businessPledgeTypeId,
            'business_name'     => $this->faker->name,
            'business_website'  => $this->faker->domainName,
            'pledge_type_id'    => PledgeType::FLAT,
            'amount'            => $flatAmount,
            'program_id'        => $this->program->id
        ]);

        // PPL
        $pplAmount = 4;
        $laps = 5;
        $participantUser = factory(User::class)->create(['laps' => $laps]);
        factory(Pledge::class)->create([
            'participant_user_id'   => $participantUser->id,
            'sponsor_type_id'       => $this->businessPledgeTypeId,
            'business_name'         => $this->faker->name,
            'business_website'      => $this->faker->domainName,
            'pledge_type_id'        => PledgeType::PPL,
            'amount'                => $pplAmount,
            'program_id'            => $this->program->id
        ]);

        // PPL w/out laps
        $participantUser = factory(User::class)->create(['laps' => null]);
        factory(Pledge::class)->create([
            'participant_user_id'   => $participantUser->id,
            'sponsor_type_id'       => $this->businessPledgeTypeId,
            'business_name'         => $this->faker->name,
            'business_website'      => $this->faker->domainName,
            'pledge_type_id'        => PledgeType::PPL,
            'amount'                => $pplAmount,
            'program_id'            => $this->program->id
        ]);

        $leaderboard = new BusinessLeaderboard($this->program);
        $pledges = $leaderboard->getPledges();

        $this->assertEqualsWithDelta($pledges[2]['total_est'], $flatAmount, 0.01);
        $this->assertEqualsWithDelta($pledges[1]['total_est'], $pplAmount * $laps, 0.01);
        $this->assertEqualsWithDelta($pledges[0]['total_est'], $pplAmount * $this->program->unit_flat_conversion, 0.01);
    }

    public function testFamilyPledgingIsAggregated()
    {
        // Flat
        $flatAmount = 4;
        factory(Pledge::class)->create([
            'sponsor_type_id'   => $this->businessPledgeTypeId,
            'business_name'     => $this->faker->name,
            'business_website'  => $this->faker->domainName,
            'pledge_type_id'    => PledgeType::FLAT,
            'amount'            => $flatAmount,
            'program_id'        => $this->program->id,
            'family_pledge_id'  => 1
        ]);

        // PPL
        $pplAmount = 4;
        $laps = 5;
        $participantUser = factory(User::class)->create(['laps' => $laps]);
        factory(Pledge::class)->create([
            'participant_user_id'   => $participantUser->id,
            'sponsor_type_id'       => $this->businessPledgeTypeId,
            'business_name'         => $this->faker->name,
            'business_website'      => $this->faker->domainName,
            'pledge_type_id'        => PledgeType::PPL,
            'amount'                => $pplAmount,
            'program_id'            => $this->program->id,
            'family_pledge_id'      => 1
        ]);

        // PPL w/out laps
        $participantUser = factory(User::class)->create(['laps' => null]);
        factory(Pledge::class)->create([
            'participant_user_id'   => $participantUser->id,
            'sponsor_type_id'       => $this->businessPledgeTypeId,
            'business_name'         => $this->faker->name,
            'business_website'      => $this->faker->domainName,
            'pledge_type_id'        => PledgeType::PPL,
            'amount'                => $pplAmount,
            'program_id'            => $this->program->id
        ]);

        $leaderboard = new BusinessLeaderboard($this->program);
        $pledges = $leaderboard->getPledges();

        $this->assertEquals(2, sizeof($pledges));
        $this->assertEqualsWithDelta($pledges[1]['total_est'], ($pplAmount * $laps) + $flatAmount, 0.01);
        $this->assertEqualsWithDelta($pledges[0]['total_est'], $pplAmount * $this->program->unit_flat_conversion, 0.01);
    }
}
