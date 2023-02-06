<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;

    public $formId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $formId)
    {
        $this->email = $email;
        $this->formId = $formId;
    }
}
