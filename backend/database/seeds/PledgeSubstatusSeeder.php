<?php

use Illuminate\Database\Seeder;
use App\Entities\PledgeSubstatus;

class PledgeSubstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PledgeSubstatus::insert([
            [
                'name'       => 'CC',
                'description'=> 'CC',
            ], [
                'name'       => 'cash',
                'description'=> 'Cash/Check',
            ], [
                'name'       => 'HVP',
                'description'=> 'HVP',
            ], [
                'name'       => 'CVP',
                'description'=> 'CVP',
            ], [
                'name'       => 'QP',
                'description'=> 'QP',
            ], [
                'name'       => 'no_substatus',
                'description'=> 'No Substatus',
            ], [
                'name'       => 'AP',
                'description'=> 'All Pledges Pending',
            ], [
                'name'       => 'HVPCC',
                'description'=> 'High value pledge for payment scheduled CC payment',
            ]
        ]);
    }
}
