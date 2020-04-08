<?php

use Illuminate\Database\Seeder;
use App\Entities\Participant;
use App\Entities\User;
use App\Entities\SponsorType;
use App\Entities\PledgeSponsor;
use App\Entities\Group;
use App\Entities\PledgeType;
use App\Entities\PledgeStatus;
use App\Entities\PledgeSubStatus;
use App\Entities\Pledge;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Generator as Faker;
use function bar\baz\foo;

class PledgeStaticSeeder extends Seeder
{
    use WithFaker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpFaker();

        $parent               = User::where('email', 'parent@example.com')->first();
        $staticParticipants   = $parent->participants;
        $staticParticipantIds = $staticParticipants->map(function ($participant) {
            return $participant->id;
        });

        $pledgeDependencies = [
            'participants'      => $staticParticipants,
            'sponsorTypes'      => SponsorType::all()->except([8, 99]),
            'groups'            => Group::all(),
            'pledgeTypes'       => PledgeType::all(),
            'pledgeStatuses'    => PledgeStatus::all()->except([3, 6, 7, 8]),
            'pledgeSubstatuses' => PledgeSubStatus::all()->except([3, 4, 5, 7, 8]),
        ];

        $PARENT_SPONSOR_TYPE_ID = 1;
        $CONFIRMED_STATUS_ID    = 2;
        $NO_SUBSTATUS_ID        = 6;

        $staticPledges = [
            [
                'pledge_type_id' => 1,
                'amount'         => 1,
            ], [
                'pledge_type_id' => 1,
                'amount'         => 2,
            ], [
                'pledge_type_id' => 3,
                'amount'         => 10,
            ], [
                'pledge_type_id' => 3,
                'amount'         => 40,
            ], [
                'pledge_type_id' => 3,
                'amount'         => 80,
            ],
        ];

        foreach ($staticParticipants as $participant) {
            foreach ($staticPledges as $staticPledge) {
                $sponsor = factory(User::class)->make();
                $sponsor->save();

                $pledgeSponsorId = PledgeSponsor::insertGetId(
                    [
                        'first_name' => $sponsor->first_name,
                        'last_name'  => $sponsor->last_name,
                        'phone'      => $sponsor->phone,
                        'email'      => $sponsor->email,
                        'address'    => $sponsor->address,
                        'city'       => $sponsor->city,
                        'state'      => $sponsor->state,
                        'zip'        => $sponsor->zip,
                        'country'    => $sponsor->country,
                    ]
                );

                $pledge = new Pledge([
                    'ip_address'          => $this->faker->ipv4,
                    'participant_user_id' => $participant->id,
                    'program_id'          => $participant->participantInfo->classroom->group->program_id,
                    'group_id'            => $participant->participantInfo->classroom->group->id,
                    'user_id'             => $sponsor->id,
                    'sponsor_type_id'     => $PARENT_SPONSOR_TYPE_ID,
                    'pledge_type_id'      => $staticPledge['pledge_type_id'], //Dynamic
                    'comment'             => substr($this->faker->sentence(), 0, 140),
                    'business_website'    => '',
                    'business_name'       => '',
                    'display_business'    => 0,
                    'anon'                => 0,
                    'anon_first_name'     => '',
                    'anon_last_name'      => '',
                    'amount'              => $staticPledge['amount'], //Dynamic
                    'pledge_status_id'    => $CONFIRMED_STATUS_ID,
                    'pledge_substatus_id' => $NO_SUBSTATUS_ID,
                    'deleted'             => 0,
                    'pledge_sponsor_id'   => $pledgeSponsorId,
                    'ts_entered'          => $this->faker->dateTimeBetween(
                        '2017-07-01 00:00:00',
                        '2017-07-31 00:00:00'
                    ),
                    'protected'           => 0,
                ]);
                $pledge->save();
            }
        }
    }
}
