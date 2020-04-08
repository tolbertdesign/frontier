<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\UserNote;

class UserNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $users->each(function ($user) {
            for ($i = 0; $i < rand(0, 3); $i++) {
                $user->userNotes()->save(factory(UserNote::class)->make());
            }
        });
    }
}
