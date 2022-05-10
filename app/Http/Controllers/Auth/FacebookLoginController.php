<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class FacebookLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        if ($user = User::where('email', $facebookUser->getEmail())->first()) {
            if ($user->provider != 'facebook') {
                return redirect()->route('login')->withErrors([
                    'email' => 'An account has already been created using this email address. Try logging in with your '.Str::title($user->provider).' account.',
                ]);
            }
        }

        $user = User::firstOrCreate(
            [
                'provider' => 'facebook',
                'provider_id' => $facebookUser->getId(),
            ],
            [
                'email' => $facebookUser->getEmail(),
                'name' => $facebookUser->getName(),
                'password' => Hash::make(Str::uuid()),
                'provider' => 'facebook',
                'provider_id' => $facebookUser->getId(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        auth()->login($user);

        if($user->accepted_terms === 1){
            $home = session('url.intended') ?? '/';

            return redirect()->intended($home);
        }else{
            return redirect()->route('terms.accept');
        }
    }
}
