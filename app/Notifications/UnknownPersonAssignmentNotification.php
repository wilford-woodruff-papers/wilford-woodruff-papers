<?php

namespace App\Notifications;

use App\Models\PeopleIdentification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnknownPersonAssignmentNotification extends Notification
{
    use Queueable;

    public PeopleIdentification $person;

    /**
     * Create a new notification instance.
     */
    public function __construct(PeopleIdentification $person)
    {
        $this->person = $person;
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
            ->subject('New Unknown Person Assigned')
            ->line('As a member of the research team, a new unknown person has been assigned to you from Wilford Woodruff\'s Papers.')
            ->action('View Unknown Person', route('admin.dashboard.identification.people.edit', ['identification' => $this->person]))
            ->line('Thank you for your help!');
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
