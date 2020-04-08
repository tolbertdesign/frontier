<?php

use Illuminate\Database\Seeder;
use App\Entities\PrizesList;

class PrizesListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PrizesList::class, 5)->make()->each(function ($prizesList) {
            $prizesList->save();
        });
    }
}
