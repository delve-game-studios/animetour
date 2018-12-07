<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class PlaylistUpdated extends Notification
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
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($playlist)
    {
        return (new SlackMessage)
            ->success()
            ->content('A playlist has been updated.')
            ->attachment(function ($attachment) use ($playlist) {
                $attachment->title($playlist->title)
                    ->fields([
                        'User' => request()->user()->name,
                        'Timestamp' => Carbon::createFromTimeString($playlist->created_at)->format('d M Y H:i'),
                    ]);
            });
    }
}
