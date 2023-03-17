<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ExportReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Your export is ready.')
            ->action('Download', Storage::disk('exports')->url($this->filename))
            ->line('Thank you!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
