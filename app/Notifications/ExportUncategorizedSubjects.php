<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ExportUncategorizedSubjects extends Notification implements ShouldQueue
{
    use Queueable;

    public $filename;

    public $subject;

    /**
     * Create a new notification instance.
     */
    public function __construct($filename, $subject = 'Export Ready Notification')
    {
        $this->filename = $filename;
        $this->subject = $subject;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        if (now()->isMonday()) {
            $start = now()->subDays(7);
            $end = now();
        } else {
            $start = now()->subDays(1);
            $end = now();
        }

        return (new MailMessage)
            ->markdown('mail.export.uncategorized-subjects', [
                'link' => url('/nova/resources/subjects?subjects_page=1&subjects_per_page=100&subjects_filter=').base64_encode(json_encode([['Rpj\\Daterangepicker\\Daterangepicker' => "'.$start.' to '.$end.'"], [\App\Nova\Filters\SubjectType::class => '-1']])),
                'download' => Storage::disk('exports')->url($this->filename),
            ])
            ->subject($this->subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
