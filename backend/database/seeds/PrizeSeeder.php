<?php

use Illuminate\Database\Seeder;
use App\Entities\Prize;

class PrizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Prize::class, 50)->create();
    }
}
