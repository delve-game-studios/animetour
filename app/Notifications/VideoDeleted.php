<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class VideoDeleted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via()
    {
        return ['slack'];
    }

    public function toSlack($video)
    {
        return (new SlackMessage)
            ->success()
            ->content('A video has been deleted.')
            ->attachment(function ($attachment) use($video) {
                $attachment
                    ->fields([
                        'Title' => $video->title,
                        'Entry Type' => $video->entry_type,
                        'User' => request()->user()->name,
                        'Timestamp' => Carbon::now()->format('d M Y H:i'),
                    ]);
            });
    }
}
