<?php

use Illuminate\Database\Seeder;
use App\Entities\FieldAlias;

class FieldAliasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FieldAlias::insert([
            ['alias' => 'First', 'field' => 'Student First Name'],
            ['alias' => 'First Name', 'field' => 'Student First Name'],
            ['alias' => 'FirstName', 'field' => 'Student First Name'],
            ['alias' => 'Grade', 'field' => 'Student Grade'],
            ['alias' => 'Grade Level', 'field' => 'Student Grade'],
            ['alias' => 'Grade Lvl', 'field' => 'Student Grade'],
            ['alias' => 'grd', 'field' => 'Student Grade'],
            ['alias' => 'grd lvl', 'field' => 'Student Grade'],
            ['alias' => 'grdlvl', 'field' => 'Student Grade'],
            ['alias' => 'Last', 'field' => 'Student Last Name'],
            ['alias' => 'Last Name', 'field' => 'Student Last Name'],
            ['alias' => 'LastName', 'field' => 'Student Last Name'],
            ['alias' => 'Legal Name', 'field' => 'Student Last Name'],
            ['alias' => 'Student First', 'field' => 'Student First Name'],
            ['alias' => 'Student First Name', 'field' => 'Student First Name'],
            ['alias' => 'Student Last', 'field' => 'Student Last Name'],
            ['alias' => 'Student Last Name', 'field' => 'Student Last Name'],
            ['alias' => 'Surname', 'field' => 'Student Last Name'],
            ['alias' => 'Teacher', 'field' => 'Teacher Full Name'],
            ['alias' => 'Teacher First', 'field' => 'Teacher First Name'],
            ['alias' => 'Teacher First Name', 'field' => 'Teacher First Name'],
            ['alias' => 'Teacher Full Name', 'field' => 'Teacher Full Name'],
            ['alias' => 'Teacher Last', 'field' => 'Teacher Last Name'],
            ['alias' => 'Teacher Last Name', 'field' => 'Teacher Last Name'],
            ['alias' => 'Teacher Name', 'field' => 'Teacher Full Name']
        ]);
    }
}
