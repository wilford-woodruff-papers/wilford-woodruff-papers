<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RelationshipFinderQueue;
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

        $familysearchUser = Socialite::driver('familysearch')->user();
        $user = auth()->user();
        $user->pid = $familysearchUser->getId();
        $user->familysearch_token = $familysearchUser->token;
        $user->familysearch_token_expiration = now()->addHours(22);
        $user->familysearch_refresh_token = $familysearchUser->refreshToken;
        $user->save();

        if (RelationshipFinderQueue::query()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->count() < 1
        ) {
            RelationshipFinderQueue::query()
                ->create([
                    'user_id' => $user->id,
                ]);
        }

        return redirect()
            ->route('my-relatives')
            ->with('status', 'You have successfully connected your FamilySearch account and we will begin checking for your relatives in Wilford Woodruff\'s Papers.');
    }
}
