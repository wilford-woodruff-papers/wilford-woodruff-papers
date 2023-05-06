<?php

namespace App\Notifications;

use App\Models\Identification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCorrectionNeeded extends Notification
{
    use Queueable;

    public $identification;

    /**
     * Create a new notification instance.
     *
     * @param  Identification  $person
     */
    public function __construct(Identification $identification)
    {
        $this->identification = $identification;
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
        return (new MailMessage)
                    ->line('A new correction has been added and needs your attention.')
                    ->action('Notification Action', route('admin.dashboard.identification.'.str($this->identification->type)->plural().'.edit', $this->identification))
                    ->line('Thank you!');
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
