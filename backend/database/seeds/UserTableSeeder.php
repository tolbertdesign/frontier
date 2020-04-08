<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\UserProfile;
use App\Entities\Participant;
use App\Entities\Program;
use App\Entities\School;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mattParker = new User([
            'ip_address'                   => 'b}{',
            'username'                     => 'mparker@boosterthon.com',
            'password'                     => '$2a$08$Qfd5H6qkBogw2W2oSkFfre94NLJC5K7.RXTukSv82x7lMmeEmxnIa',
            'salt'                         => 'f9db975370',
            'email'                        => 'mparker@boosterthon.com',
            'activation_code'              => null,
            'forgotten_password_code'      => null,
            'forgotten_password_time'      => null,
            'remember_code'                => null,
            'created_on'                   => 1439496110,
            'last_login'                   => 1505763478,
            'active'                       => 1,
            'first_name'                   => 'Matthew',
            'last_name'                    => 'Parker',
            'phone'                        => '',
            'fr_code'                      => null,
            'address'                      => '',
            'city'                         => '',
            'state'                        => '',
            'zip'                          => '',
            'country'                      => '',
            'company'                      => null,
            'gender'                       => '',
            'in_service'                   => null,
            'dob'                          => null,
            'origin'                       => 'sf_vanahcm',
            'salesforce_worker_id'         => 'a3BU0000000w6llMAA',
            'salesforce_user_id'           => '005U0000004jVX1IAM',
            'salesforce_team_id'           => 'a1sU0000001FDAGIA4',
            'salesforce_profile_id'        => null,
            'salesforce_contact_id'        => null,
            'laps'                         => null,
            'api_token'                    => null,
            'registered'                   => 0,
            'waiver_signed'                => 0,
            'waiver_dob'                   => null,
            'waiver_ts'                    => null,
            'deleted'                      => 0,
            'flagging_mode_id'             => 1,
            'block_collection_reminder'    => 0,
            'reg_code_temp_user'           => 0,
            'email_opt_out'                => 0,
            'ts_laps_entered'              => null,
            'public_pledger'               => 0,
            'requested_pay_later_override' => null,
            'remember_token'               => null,
            'created_at'                   => null,
            'updated_at'                   => null,
            'deleted_at'                   => null,
        ]);

        $danielPitsko = new User([
            'ip_address'                   => 'h-.',
            'username'                     => 'dpitsko@boosterthon.com',
            'password'                     => '$2a$08$7p4FHLd14DeTwlFAw7Yuperbci8Sgj320RO11i.lJ3RhpNXmmun5q',
            'salt'                         => '99fabb6108',
            'email'                        => 'dpitsko@boosterthon.com',
            'activation_code'              => null,
            'forgotten_password_code'      => '2b7f8334ba3bcfe422edf51251056e7752d69542',
            'forgotten_password_time'      => 1502808475,
            'remember_code'                => '27bdb63db981b78e14599861199d3b94fe6ec53c',
            'created_on'                   => 1412077787,
            'last_login'                   => 1515595682,
            'active'                       => 1,
            'first_name'                   => 'Daniel',
            'last_name'                    => 'Pitsko',
            'phone'                        => '',
            'fr_code'                      => null,
            'address'                      => '',
            'city'                         => '',
            'state'                        => '',
            'zip'                          => '',
            'country'                      => '',
            'company'                      => null,
            'gender'                       => '',
            'in_service'                   => null,
            'dob'                          => null,
            'origin'                       => 'sf_vanahcm',
            'salesforce_worker_id'         => 'a3BU00000002ocRMAQ',
            'salesforce_user_id'           => '005U0000003Y63aIAC',
            'salesforce_team_id'           => 'a1sU0000001FDAGIA4',
            'salesforce_profile_id'        => null,
            'salesforce_contact_id'        => null,
            'laps'                         => null,
            'api_token'                    => null,
            'registered'                   => 0,
            'waiver_signed'                => 0,
            'waiver_dob'                   => null,
            'waiver_ts'                    => null,
            'deleted'                      => 0,
            'flagging_mode_id'             => 1,
            'block_collection_reminder'    => 0,
            'reg_code_temp_user'           => 0,
            'email_opt_out'                => 0,
            'ts_laps_entered'              => null,
            'public_pledger'               => 0,
            'requested_pay_later_override' => null,
            'remember_token'               => 'Qst9zOXv7uI1WzH5UVgXl4uWiLo8ueETP9BoxabwCnslYeQn4Ex9GzfipLTl',
            'created_at'                   => null,
            'updated_at'                   => null,
            'deleted_at'                   => null
        ]);

        $ianMackenzie = new User([
            'ip_address'                   => '??',
            'username'                     => 'ianm@boosterthon.com',
            'password'                     => '$2a$08$ys4czy84xrIe35dnmNtx8.Pnik6ldylP2jACJrgHYnRNH8pcRnPrW',
            'salt'                         => 'b36a02bb21',
            'email'                        => 'ianm@boosterthon.com',
            'activation_code'              => null,
            'forgotten_password_code'      => null,
            'forgotten_password_time'      => null,
            'remember_code'                => null,
            'created_on'                   => 1502116760,
            'last_login'                   => 1502116760,
            'active'                       => 1,
            'first_name'                   => 'Ian',
            'last_name'                    => 'Mackenzie',
            'phone'                        => null,
            'fr_code'                      => null,
            'address'                      => null,
            'city'                         => null,
            'state'                        => null,
            'zip'                          => null,
            'country'                      => null,
            'company'                      => null,
            'gender'                       => null,
            'in_service'                   => null,
            'dob'                          => null,
            'origin'                       => 'sf_vanahcm',
            'salesforce_worker_id'         => 'a3B0P000000wa00UAA',
            'salesforce_user_id'           => '0050P000006kR9oQAE',
            'salesforce_team_id'           => 'a1sU0000001FDAGIA4',
            'salesforce_profile_id'        => null,
            'salesforce_contact_id'        => null,
            'laps'                         => null,
            'api_token'                    => null,
            'registered'                   => 0,
            'waiver_signed'                => 0,
            'waiver_dob'                   => null,
            'waiver_ts'                    => null,
            'deleted'                      => 0,
            'flagging_mode_id'             => 1,
            'block_collection_reminder'    => 0,
            'reg_code_temp_user'           => 0,
            'email_opt_out'                => 0,
            'ts_laps_entered'              => null,
            'public_pledger'               => 0,
            'requested_pay_later_override' => null,
            'remember_token'               => null,
            'created_at'                   => null,
            'updated_at'                   => null,
            'deleted_at'                   => null
        ]);

        $adminRoles = [
            'admin',
            'members',
            'System Administrator',
            'Home Office',
            'Atlanta',
            'Test',
        ];

        $parentRoles = [
            'members',
            'parents',
        ];

        $participantRoles = [
            'members',
            'students'
        ];

        $mattParker->save();
        $mattParker->assignRole($adminRoles);
        $danielPitsko->save();
        $danielPitsko->assignRole($adminRoles);
        $ianMackenzie->save();
        $ianMackenzie->assignRole($adminRoles);

        //Creating a parent with family pledging participants for tests
        $parent             = factory(User::class)->make();
        $parent->first_name = 'parent';
        $parent->last_name  = 'parent';
        $parent->email      = 'parent@example.com';
        $parent->username   = 'parent@example.com';
        $parent->password   = bcrypt('secret');
        $parent->save();
        $parent->assignRole($parentRoles);

        $siblings = factory(User::class, 2)->make()->each(function ($sibling, $key) use ($parent, $participantRoles) {
            $sibling->first_name = 'sibling' . $key;
            $sibling->last_name = 'sibling' . $key;
            $sibling->dob = null;
            $sibling->waiver_signed = true;
            $sibling->waiver_ts = Carbon::now()->format('Y-m-d H:i:s');
            $sibling->save();
            $sibling->participantInfo()->save(
                new Participant([
                    'classroom_id'             => 126106,
                    'family_pledging_enabled'  => 1,
                    'allow_pay_later_override' => 0,
                ])
            );
            $parent->participants()->save($sibling);
            $sibling->assignRole($participantRoles);
            $sibling->profile()->save(factory(UserProfile::class)->make());
        });

        //parent factory loop
        factory(User::class, 20)->make()->each(function ($parent) use ($parentRoles, $participantRoles) {
            $parent->save();
            $parent->assignRole($parentRoles);

            //participant factory loop
            factory(User::class, rand(1, 4))->make()->each(function ($participant) use ($participantRoles, $parent) {
                $participant->dob = null;
                $participant->save();
                $participant->participantInfo()->save(
                    new Participant([
                        'classroom_id'             => 126106,
                        'family_pledging_enabled'  => null,
                        'allow_pay_later_override' => 0,
                    ])
                );
                $parent->participants()->save($participant);
                $participant->assignRole($participantRoles);
                $participant->profile()->save(factory(UserProfile::class)->make());
            });
        });

        //parent factory loop
        factory(User::class, 1)->create(
            [
                'email'    => 'parent+odd@boosterthon.com',
                'username' => 'parent+odd@boosterthon.com'
            ]
        )->each(function ($parent) use ($parentRoles, $participantRoles) {
            $parent->forceDelete();
            if ($parent->id % 2 === 0) {
                $parent->id += 1;
            }
            $parent->save();
            $parent->assignRole($parentRoles);

            //participant factory loop
            factory(User::class, rand(1, 4))->make(
                [
                    'waiver_signed' => true,
                    'waiver_ts'     => \Carbon\Carbon::now()
                ]
            )->each(function ($participant) use ($participantRoles, $parent) {
                $participant->dob = null;
                $participant->save();
                $participant->participantInfo()->save(
                    new Participant([
                        'classroom_id'             => 126106,
                        'family_pledging_enabled'  => null,
                        'allow_pay_later_override' => 0,
                    ])
                );
                $parent->participants()->save($participant);
                $participant->assignRole($participantRoles);
                $participant->profile()->save(factory(UserProfile::class)->make());
            });
        });

        factory(User::class, 1)->create(
            [
                'email'    => 'parent+even@boosterthon.com',
                'username' => 'parent+even@boosterthon.com'
            ]
        )->each(function ($parent) use ($parentRoles, $participantRoles) {
            $parent->forceDelete();
            if ($parent->id % 2 === 1) {
                $parent->id += 1;
            }
            $parent->save();
            $parent->assignRole($parentRoles);

            //participant factory loop
            factory(User::class, rand(1, 4))->make(
                [
                    'waiver_signed' => true,
                    'waiver_ts'     => \Carbon\Carbon::now()
                ]
            )->each(function ($participant) use ($participantRoles, $parent) {
                $participant->dob = null;
                $participant->save();
                $participant->participantInfo()->save(
                    new Participant([
                        'classroom_id'             => 126106,
                        'family_pledging_enabled'  => null,
                        'allow_pay_later_override' => 0,
                    ])
                );
                $parent->participants()->save($participant);
                $participant->assignRole($participantRoles);
                $participant->profile()->save(factory(UserProfile::class)->make());
            });
        });
    }
}
