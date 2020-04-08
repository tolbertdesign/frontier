<?php

use Illuminate\Database\Seeder;
use App\Entities\Pledge;
use App\Entities\Referrer;

class PledgeReferrerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pledges   = Pledge::all();
        $referrers = Referrer::all();

        $pledges->each(function ($pledge) use ($referrers) {
            $pledge->referrers()->save($referrers->random());
        });
    }
}
