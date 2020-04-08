<?php

use Illuminate\Database\Seeder;
use App\Entities\Participant;
use App\Entities\User;
use App\Entities\UserActivity;
use App\Entities\UserActivityHistory;

class UserActivityHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $participants      = Participant::pluck('user_id')->all();
        $users             = User::whereNotIn('id', $participants)->orderByRaw('RAND()')->take(20)->get();
        $userActivityTypes = UserActivity::all()->toArray();
        foreach ($users as $key => $user) {
            $rand_key              = array_rand($userActivityTypes, 1);
            $userActivityHistory[] = [
                    'user_id'     => $user->id,
                    'activity_id' => $userActivityTypes[$rand_key]['id']
                ];
        };
        UserActivityHistory::insert($userActivityHistory);
    }
}
