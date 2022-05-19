<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dymantic\InstagramFeed\Profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class InstagramAuthController extends Controller
{
    public function __invoke()
    {
        $profile = Profile::where('username', 'wilford_woodruff_papers')->first();

        return redirect()->away($profile->getInstagramAuthUrl());
    }
}
