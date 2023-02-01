<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dymantic\InstagramFeed\Profile;

class InstagramAuthController extends Controller
{
    public function __invoke()
    {
        $profile = Profile::where('username', 'wilford_woodruff_papers')->first();

        return redirect()->away($profile->getInstagramAuthUrl());
    }
}
