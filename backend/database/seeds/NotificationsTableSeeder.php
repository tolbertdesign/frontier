<?php

use App\Entities\Notification;
use App\Entities\User;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Notification::class, 1)->create([
            'notifiable_id' => User::where('email', 'parent@example.com')->first()->id,
            'program_id' => 1
        ]);
    }
}
