<?php

use Illuminate\Database\Seeder;
use App\Entities\UserFlaggingMode;

class UserFlaggingModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pgm = new UserFlaggingMode([
            'id'          => 1,
            'name'        => 'PGM',
            'description' => 'Use Program Flagging Mode',
        ]);
        $pgm->save();

        $all = new UserFlaggingMode([
            'id'          => 2,
            'name'        => 'ALL',
            'description' => 'Flag All User Pledges',
        ]);
        $all->save();

        $none = new UserFlaggingMode([
            'id'          => 3,
            'name'        => 'NONE',
            'description' => 'Flag No User Pledges',
        ]);
        $none->save();
    }
}
