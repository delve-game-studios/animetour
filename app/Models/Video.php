<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Video extends Model
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $casts = [
        'verified' => 'boolean'
    ];

    const ENTRY_FILE = 'File';
    const ENTRY_URL = 'URL';

    const FILE_DISK = 'public';
    const FILE_FOLDER = 'videos';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->perPage = env('MODEL_PAGINATE_SIZE', 20);
    }

    public function routeNotificationFor($driver, $notification = null)
    {
        return (env('SLACK_NOTIFICATION_ENABLED') === false) ? null : config('app.slack_notification_url');
    }

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_video', 'video_id', 'playlist_id', 'id');
    }

    public function getPlaylistAttribute()
    {
        return $this->playlists[0];
    }
}
