<?php

use Illuminate\Database\Seeder;
use App\Entities\BraintreeMerchant;
use App\Entities\School;

class BraintreeMerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $braintreeMerchant = new BraintreeMerchant([
            // 'id'                    => 1,
            'first_name'            => 'Jessicac',
            'last_name'             => 'Millerddc',
            'email'                 => 'jmkim827+sftestorgadmin@gmail.com',
            'point_person_phone'    => 4044066964,
            'dob'                   => '1986-08-27',
            'point_person_address'  => '1000 Mansell Exch W Ste 350',
            'point_person_city'     => 'Alpharetta',
            'point_person_state'    => 'GA',
            'point_person_zip'      => 30022,
            'legal_name'            => 'Booster Enterprises',
            'dba'                   => 'funrun.com',
            'tax_id'                => '562305120',
            'organization_address'  => '1000 Mansell Exch W Ste 350',
            'organization_city'     => 'Alpharetta',
            'organization_state'    => 'IL',
            'organization_zip'      => 30396,
            'account_number'        => '****9507',
            'routing_number'        => '*******7',
            'school_id'             => 1,
            'status'                => 'active',
            'tos'                   => 1,
            'approval_status'       => 'approved',
            'error_message'         => null,
            'errors'                => null,
            'braintree_merchant_id' => 'salesforcekenny_2',
            'escrow_funds'          => 1,
            'account_type'          => '',
        ]);
        $braintreeMerchant->save();

        $schools = School::where('id', '!=', 1)->get();
        foreach ($schools as $school) {
            factory(BraintreeMerchant::class, 1)->create(['school_id' => $school->id]);
        }
    }
}
