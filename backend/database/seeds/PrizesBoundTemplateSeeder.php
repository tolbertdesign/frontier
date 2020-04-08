<?php

use Illuminate\Database\Seeder;
use App\Entities\PrizesList;
use App\Entities\Prize;
use App\Entities\PrizesBoundTemplate;

class PrizesBoundTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prizeLists = PrizesList::all();
        $prizes     = Prize::all();
        while ($prizeLists->count() > 0) {
            $prizeList    = $prizeLists->shift();
            $randomPrizes = $prizes->random(rand(5, 10));
            $randomPrizes->each(
                function ($prize) use ($prizeList) {
                    factory(PrizesBoundTemplate::class, rand(5, 10))
                        ->make()
                        ->each(
                            function ($prizesBoundTemplate) use ($prizeList, $prize) {
                                $prizesBoundTemplate->prize_id      = $prize->id;
                                $prizesBoundTemplate->prize_list_id = $prizeList->id;
                                $prizesBoundTemplate->display_name = $prize->display_name;
                                $prizesBoundTemplate->save();
                            }
                        );
                }
            );
        }
    }
}
