<?php

use Illuminate\Database\Seeder;
use App\Entities\Participant;
use App\Entities\User;
use App\Entities\OrganizationAdministrator;
use App\Entities\School;

class OrganizationAdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orgAdminRules = [
            'members',
            'parents',
            // 'Test',
            'Organization Admin'
        ];

        $orgAdminUser             = factory(User::class)->make();
        $orgAdminUser->email      = 'orgadmin@boosterthon.com';
        $orgAdminUser->username   = 'orgadmin@boosterthon.com';
        $orgAdminUser->password   = bcrypt('secret');
        $orgAdminUser->save();
        $orgAdminUser->assignRole($orgAdminRules);
        $school = School::first();
        $school->orgAdmins()->save($orgAdminUser);
        // $program->org

        $participants      = Participant::pluck('user_id')->all();
        $users             = User::whereNotIn('id', $participants)->orderByRaw('RAND()')->get();
        $schools           = School::all();
        foreach ($schools as $key => $school) {
            $orgAdmins[] = [
                'user_id'             => $users[$key]->id,
                'school_id'           => $school->id,
                'receive_task_emails' => 1,
            ];
        }
        OrganizationAdministrator::insert($orgAdmins);
    }
}
