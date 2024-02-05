<?php

namespace App\Notifications;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PersonAssignmentNotification extends Notification
{
    use Queueable;

    public Subject $person;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subject $person)
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->person->name.' assigned to you')
            ->line('As a member of the research team, '.$this->person->name.' has been assigned to you from Wilford Woodruff\'s Papers.')
            ->action('View Person', route('admin.dashboard.people.edit', ['person' => $this->person]))
            ->line('Thank you for your help!');
    }

    public function toDatabase(User $notifiable): array
    {
        return \Filament\Notifications\Notification::make()
            ->title($this->person->name.' assigned to you')
            ->body('As a member of the research team, '.$this->person->name.' has been assigned to you from Wilford Woodruff\'s Papers.')
            ->actions([
                \Filament\Notifications\Actions\Action::make('view_person')
                    ->button()
                    ->url(route('admin.dashboard.people.edit', ['person' => $this->person])),
            ])
            ->getDatabaseMessage();
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
