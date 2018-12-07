<?php

use App\Models\Playlist;
use Illuminate\Database\Seeder;

class Playlists extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Playlist::create([
            'id' => 1,
            'title' => 'Naruto Shippuden'
        ]);
    }
}
