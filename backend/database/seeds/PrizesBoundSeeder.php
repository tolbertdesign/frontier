<?php

use Illuminate\Database\Seeder;
use App\Entities\PrizesBound;
use App\Entities\Prize;
use App\Entities\Group;

class PrizesBoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = Group::all();
        $prizes = Prize::all();
        while ($groups->count() > 0) {
            $group = $groups->pop();

            factory(PrizesBound::class, rand(10, 30))->create()->each(function ($prizeBound) use ($group, $prizes) {
                $prize = $prizes->random();
                while (PrizesBound::where('prize_id', $prize->id)->where('group_id', $group->id)->exists()) {
                    $prize = $prizes->random();
                }
                $prizeBound->group_id = $group->id;
                $prizeBound->prize_id = $prize->id;
                $prizeBound->display_name = $prize->name;
                $prizeBound->save();
            });

            factory(PrizesBound::class, 1)->create()->each(function ($prizeBound) use ($group, $prizes) {

                $prize = $prizes->random();
                while (PrizesBound::where('prize_id', $prize->id)->where('group_id', $group->id)->exists()) {
                    $prize = $prizes->random();
                }
                $prizeBound->display_amount        = 0;
                $prizeBound->actual_amount         = 0;
                $prizeBound->pledge_period_ordinal = 0;
                $prizeBound->activity_reward       = 2;
                $prizeBound->prize_id              = $prize->id;
                $prizeBound->display_name          = $prize->name;
                $prizeBound->group_id              = $group->id;
                $prizeBound->save();
            });
        }
    }
}
