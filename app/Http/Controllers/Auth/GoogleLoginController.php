<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
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
     */
    public function handleProviderCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        if ($user = User::where('email', $googleUser->getEmail())->first()) {
            if (! in_array($user->provider, ['google', 'email'])) {
                return redirect()->route('login')->withErrors([
                    'email' => 'An account has already been created using this email address. Try logging in with your '.Str::title($user->provider).' account.',
                ]);
            }

            $user->fill([
                'provider' => 'google',
                'password' => $googleUser->getId(),
                'provider_id' => Hash::make(Str::uuid()),
            ]);
            $user->save();
        } else {
            $user = User::create([
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'provider' => 'google',
                'password' => $googleUser->getId(),
                'provider_id' => Hash::make(Str::uuid()),
            ]);
            event(new Registered($user));
        }

        auth()->login($user);

        if ($user->accepted_terms === 1) {
            $home = session('url.intended') ?? '/';

            return redirect()->intended($home);
        } else {
            return redirect()->route('terms.accept');
        }
    }
}
