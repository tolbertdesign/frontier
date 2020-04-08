<?php

use Illuminate\Database\Seeder;
use App\Entities\PledgeStatus;

class PledgeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PledgeStatus::insert([
            [
                'name'=> 'entered',
            ], [
                'name'=> 'confirmed',
            ], [
                'name'=> 'paid',
            ], [
                'name'=> 'pending',
            ], [
                'name'=> 'deleted',
            ], [
                'name'=> 'cancelled',
            ], [
                'name'=> 'abandoned',
            ], [
                'name'=> 'payment scheduled',
            ]
        ]);
    }
}
