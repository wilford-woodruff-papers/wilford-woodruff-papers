<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class RelationshipFinderCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Collection $relationships,
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('We have finished checking the Wilford Woodruff Papers for your relatives.')
            ->action('View Results', url('/'))
            ->line('Have a great day!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
