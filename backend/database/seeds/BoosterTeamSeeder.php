<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class BoosterTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'first_name' => 'Anthony',
            'last_name' => 'Lee',
            'email' => 'anthonyl@boosterthon.com',
            'password' => bcrypt('password'),
        ]);
        factory(User::class)->create([
            'first_name' => 'Chris',
            'last_name' => 'Lanham',
            'email' => 'chrisl@boosterthon.com',
            'password' => bcrypt('password'),
        ]);
        factory(User::class)->create([
            'first_name' => 'Christy',
            'last_name' => 'Kudlac',
            'email' => 'christyk@boosterthon.com',
            'password' => bcrypt('password'),
        ]);
        factory(User::class)->create([
            'first_name' => 'Jeff',
            'last_name' => 'Dernavich',
            'email' => 'jeffd@boosterthon.com',
            'password' => bcrypt('password'),
        ]);
        factory(User::class)->create([
            'first_name' => 'Jey',
            'last_name' => 'Choi',
            'email' => 'jeyc@boosterthon.com',
            'password' => bcrypt('password'),
        ]);
        factory(User::class)->create([
            'first_name' => 'Josh',
            'last_name' => 'McCarty',
            'email' => 'joshmccarty@boosterthon.com',
            'password' => bcrypt('password'),
        ]);

        factory(User::class)->create([
            'first_name' => 'Kenny',
            'last_name' => 'Gutierrez',
            'email' => 'kennyg@boosterthon.com',
            'password' => bcrypt('password'),
        ]);

        factory(User::class)->create([
            'first_name' => 'Logan',
            'last_name' => 'Antcliff',
            'email' => 'lantcliff@boosterthon.com',
            'password' => bcrypt('password'),
        ]);

        factory(User::class)->create([
            'first_name' => 'Matt',
            'last_name' => 'Selee',
            'email' => 'mattselee@boosterthon.com',
            'password' => bcrypt('password'),
        ]);

        factory(User::class)->create([
            'first_name' => 'Miguel',
            'last_name' => 'Williams',
            'email' => 'mwilliams@boosterthon.com',
            'password' => bcrypt('password'),
        ]);

        factory(User::class)->create([
            'first_name' => 'Tood',
            'last_name' => 'Trappe',
            'email' => 'toddt@boosterthon.com',
            'password' => bcrypt('password'),
        ]);

        factory(User::class)->create([
            'first_name' => 'Victor',
            'last_name' => 'Tolbert',
            'email' => 'victortolbert@boosterthon.com',
            'password' => bcrypt('password'),
        ]);
    }
}
