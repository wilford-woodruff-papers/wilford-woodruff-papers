<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UserLoginAtListener
{
    public function __construct()
    {
    }

    public function handle(Login $event): void
    {
        $event->user->update([
            'last_login_at' => now(),
        ]);
    }
}
