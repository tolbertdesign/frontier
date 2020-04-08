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

class PledgeSeeder extends Seeder
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
        $participantIds = Participant::whereNotIn('user_id', $staticParticipantIds)->pluck('user_id')->all();

        $pledgeDependencies = [
            'participants'      => User::whereIn('id', $participantIds)->orderByRaw('RAND()')->get(),
            'sponsorTypes'      => SponsorType::all()->except([8, 99]),
            'groups'            => Group::all(),
            'pledgeTypes'       => PledgeType::all(),
            'pledgeStatuses'    => PledgeStatus::all()->except([3, 6, 7, 8]),
            'pledgeSubstatuses' => PledgeSubStatus::all()->except([3, 4, 5, 7, 8]),
        ];

        factory(User::class, 200)->make()->each(function ($sponsor) use ($pledgeDependencies) {
            $sponsor->save();

            extract($pledgeDependencies);

            $pledgeSponsorId = PledgeSponsor::insertGetId(
                [
                    'first_name'  => $sponsor->first_name,
                    'last_name'   => $sponsor->last_name,
                    'phone'       => $sponsor->phone,
                    'email'       => $sponsor->email,
                    'address'     => $sponsor->address,
                    'city'        => $sponsor->city,
                    'state'       => $sponsor->state,
                    'zip'         => $sponsor->zip,
                    'country'     => $sponsor->country,
                ]
            );

            for ($i=0; $i < rand(1, 3); $i++) {
                $sponsorType       = $sponsorTypes->random();
                $group             = $groups->random();
                $pledgeType        = $pledgeTypes->random();

                $businessWebsite = ($sponsorType->sponsor_type == 'Business') ? $this->faker->url : '';
                $businessName    = ($sponsorType->sponsor_type == 'Business') ? $this->faker->company : '';

                $pledgeAmountMax = 5;
                if ($pledgeType->long_name == 'Flat Donation') {
                    $pledgeAmountMax = 100;
                }
                $amount = rand(1, $pledgeAmountMax);

                $anon = rand(0, 1);
                if ($anon) {
                    $anonFirstName = $sponsor['first_name'];
                    $anonLastName  = $sponsor['last_name'];
                } else {
                    $anonFirstName = null;
                    $anonLastName  = null;
                }

                $participant = $participants->random();
                $pledge = new Pledge([
                    'ip_address'          => $this->faker->ipv4,
                    'participant_user_id' => $participant->id,
                    'program_id'          => $participant->participantInfo->classroom->group->program_id,
                    'group_id'            => $participant->participantInfo->classroom->group->id,
                    'user_id'             => $sponsor->id,
                    'sponsor_type_id'     => $sponsorType->id,
                    'pledge_type_id'      => $pledgeType->id,
                    'business_website'    => $businessWebsite,
                    'comment'             => substr($this->faker->sentence(), 0, 140),
                    'business_name'       => $businessName,
                    'anon'                => $anon,
                    'anon_first_name'     => $anonFirstName,
                    'anon_last_name'      => $anonLastName,
                    'amount'              => $amount,
                    'pledge_status_id'    => $pledgeStatuses->random()->id,
                    'pledge_substatus_id' => $pledgeSubstatuses->random()->id,
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
        });
    }
}
