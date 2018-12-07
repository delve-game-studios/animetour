<?php

namespace App\Observers;

use App\Models\Playlist;
use App\Notifications\PlaylistCreated;
use App\Notifications\PlaylistDeleted;
use App\Notifications\PlaylistUpdated;

class Playlists
{
    /**
     * Handle the playlist "created" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function created(Playlist $playlist)
    {
        $playlist->notify(new PlaylistCreated());
    }

    /**
     * Handle the playlist "updated" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function updated(Playlist $playlist)
    {
        $playlist->notify(new PlaylistUpdated());
    }

    /**
     * Handle the playlist "deleted" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function deleted(Playlist $playlist)
    {
        $playlist->notify(new PlaylistDeleted());
    }
}
