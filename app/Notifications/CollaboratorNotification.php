<?php

namespace App\Notifications;

use App\Models\ContestSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CollaboratorNotification extends Notification
{
    use Queueable;

    public ContestSubmission $submission;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ContestSubmission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->replyTo(config('wwp.admin_email'))
                    ->line('We received your submission to the Wilford Woodruff Papers Foundation 2023 Conference Art Contest')
                    ->line('Please click on the link below to update your contact information.')
                    ->action('Update Contact Information', route('conference.art-contest-entry-form-collaborator', [
                        'submission' => $this->submission->uuid,
                        'contestant' => $notifiable->uuid,
                    ]))
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
