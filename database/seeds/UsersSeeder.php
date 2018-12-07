<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->create([
            'active' => true,
            'name' => 'Milan Vugrinchev',
            'email' => 'm@anime-tour.io',
            'password' => bcrypt(1),
        ]);
    }
}
