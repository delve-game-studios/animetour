<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Playlist extends Model
{
    use Notifiable;

    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->perPage = env('MODEL_PAGINATE_SIZE', 20);
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'playlist_video', 'playlist_id', 'video_id', 'id');
    }

    public function routeNotificationFor($driver, $notification = null)
    {
        return (env('SLACK_NOTIFICATION_ENABLED') === false) ? null : config('app.slack_notification_url');
    }

}
