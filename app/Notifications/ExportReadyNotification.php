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

    public $subject;

    public function __construct($filename, $subject = 'Export Ready Notification')
    {
        $this->filename = $filename;
        $this->subject = $subject;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        if (now()->isMonday()) {
            $start = now()->subDays(7);
            $end = now();
        } else {
            $start = now()->subDays(1);
            $end = now();
        }

        return (new MailMessage)
            ->subject($this->subject)
            ->line('Your export is ready.')
            ->action('Download', Storage::disk('exports')->url($this->filename))
            ->action('View in Nova', url('/nova/resources/subjects?subjects_page=1&subjects_per_page=100&subjects_filter=').base64_encode(json_encode([['Rpj\\Daterangepicker\\Daterangepicker' => "'.$start.' to '.$end.'"]])))
            ->line('Thank you!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
