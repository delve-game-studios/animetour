<?php

namespace App\Notifications;

use App\Models\Playlist;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class VideosUploaded extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($video)
    {
        return (new SlackMessage)
            ->success()
            ->content('A video has been uploaded.')
            ->attachment(function ($attachment) use ($video) {
                $url = $video->entry_type === Video::ENTRY_FILE ?  url('/storage/'. $video->entry) : $video->entry;
                $playlist = Playlist::find(request('playlist')) ?? Playlist::find(1);

                $attachment->title($video->title, $url)
                    ->fields([
                        'Playlist' => $playlist->title,
                        'Entry Type' => $video->entry_type,
                        'User' => request()->user()->name ?? 'System',
                        'Timestamp' => Carbon::createFromTimeString($video->created_at)->format('d M Y H:i'),
                    ]);
            });
    }
}
