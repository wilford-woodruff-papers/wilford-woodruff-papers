<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class FamilySearchLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('familysearch')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleProviderCallback(): RedirectResponse
    {
        // $familysearchUser = Socialite::driver('familysearch')->user();
        $familysearchUser = Socialite::driver('familysearch')->user();
        $user = auth()->user();
        $user->pid = $familysearchUser->getId();
        $user->save();
        dd($familysearchUser);
    }
}
