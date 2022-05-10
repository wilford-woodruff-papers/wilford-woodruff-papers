<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        if ($user = User::where('email', $googleUser->getEmail())->first()) {
            if ($user->provider != 'google') {
                return redirect()->route('login')->withErrors([
                    'email' => 'An account has already been created using this email address. Try logging in with your '.Str::title($user->provider).' account.',
                ]);
            }
        }

        $user = User::firstOrCreate(
            [
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
            ],
            [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'password' => Hash::make(Str::uuid()),
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        auth()->login($user);

        $home = session('url.intended') ?? '/';

        return redirect()->intended($home);
    }
}
