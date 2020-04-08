<?php

use Illuminate\Database\Seeder;
use App\Entities\UserEmailOptOut;
use App\Entities\Participant;
use App\Entities\User;
use App\Entities\UserEmailType;

class UserEmailOptOutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $participants   = Participant::pluck('user_id')->all();
        $users          = User::whereNotIn('id', $participants)->orderByRaw('RAND()')->take(10)->get();
        $userEmailTypes = UserEmailType::all()->toArray();
        foreach ($users as $key => $user) {
            factory(UserEmailOptOut::class, 1)->make()->each(function ($userEmailOptOut) use ($user, $userEmailTypes) {
                $rand_key                            = array_rand($userEmailTypes, 1);
                $userEmailOptOut->email              = $user->email;
                $userEmailOptOut->user_email_type_id = $userEmailTypes[$rand_key]['id'];
                $userEmailOptOut->save();
            });
        }
    }
}
