<?php

namespace App\Observers;

use App\Models\Video;
use App\Notifications\VideoDeleted;
use App\Notifications\VideosUploaded;

class Videos
{
    /**
     * Handle the video "created" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function created(Video $video)
    {
        $video->notify(new VideosUploaded());
    }

    /**
     * Handle the video "deleted" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function deleted(Video $video)
    {
        if (request()->has('viaPlaylist') && !request()->get('viaPlaylist')) {
            $video->notify(new VideoDeleted());
        }
    }
}
