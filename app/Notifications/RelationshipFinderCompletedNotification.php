<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RelationshipFinderCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
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
