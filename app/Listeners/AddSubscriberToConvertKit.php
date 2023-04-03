<?php

namespace App\Listeners;

use App\Events\ContactFormSubmitted;
use Illuminate\Support\Facades\Http;

class AddSubscriberToConvertKit
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactFormSubmitted $event): void
    {
        Http::post('https://api.convertkit.com/v3/forms/'.$event->formId.'/subscribe', [
            'api_key' => config('convertkit.api_key'),
            'email' => $event->email,
        ]);
    }
}
