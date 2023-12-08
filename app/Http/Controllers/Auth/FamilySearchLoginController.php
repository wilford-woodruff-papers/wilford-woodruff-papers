<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
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
        $user->familysearch_token = $familysearchUser->token;
        $user->familysearch_refresh_token = $familysearchUser->refreshToken;
        $user->save();

        dd($familysearchUser);

        $response = Http::withToken($user->familysearch_token)
            ->acceptJson()
            ->get(config('services.familysearch.base_uri').'/platform/tree/persons/CURRENT/relationships/KWJ6-4JT');
        \Storage::disk('local')
            ->put('example-relationship.json', $response->body());

    }
}
