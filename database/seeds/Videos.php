<?php

use App\Models\PlaylistVideo;
use App\Models\Video;
use Illuminate\Database\Seeder;

class Videos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Video::create([
                'id' => $i,
                'title' => 'Episode ' . $i,
                'entry' => 'path/to/file',
                'entry_type' => 'File',
            ]);

            PlaylistVideo::create([
                'playlist_id' => 1,
                'video_id' => $i
            ]);
        }
    }
}
