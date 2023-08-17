<?php

namespace App\Http\Controllers\Auth;

use App\Actions\SubscribeToConstantContactAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Jetstream\Jetstream;

class AcceptTermsOfUseController extends Controller
{
    /**
     * Show form.
     */
    public function show(): View
    {
        $termsFile = Jetstream::localizedMarkdownPath('terms.md');

        return view('auth.accept-terms-of-use', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }

    /**
     * Process form.
     */
    public function submit(Request $request, SubscribeToConstantContactAction $subscribeToConstantContactAction): RedirectResponse
    {
        $user = Auth::user();
        $user->accepted_terms = 1;
        $user->save();

        if ($request->boolean('subscribe_to_newsletter') == true) {
            $subscribeToConstantContactAction->execute([
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ],
                [
                    config('wwp.list_memberships.newsletter'),
                ]
            );
        }

        $home = session('url.intended') ?? '/';

        return redirect()->intended($home);
    }
}
