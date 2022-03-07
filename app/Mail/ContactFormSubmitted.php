<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.contact-form-submitted')
            ->cc(User::role('Super Admin')->pluck('email')->all());
    }
}
