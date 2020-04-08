<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\UserNewFrCode;

class UserNewFrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users   = User::all();
        $frCodes = $users->map(function ($user) {
            $frCode = [
                'id'      => $user->id,
                'fr_code' => $user->fr_code,
            ];
            return $frCode;
        })->filter(function ($frCode) {
            return $frCode['fr_code'];
        })->toArray();
        UserNewFrCode::insert($frCodes);
    }
}
