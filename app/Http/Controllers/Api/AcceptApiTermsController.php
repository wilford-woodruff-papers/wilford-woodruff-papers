<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;

class AcceptApiTermsController extends Controller
{
    /**
     * Show form.
     */
    public function show(Request $request)
    {

        $home = session('url.intended') ?? '/';

        $termsFile = Jetstream::localizedMarkdownPath('api-terms.md');

        if (! $request->user()->hasAcceptedApiTerms()) {
            return view('api.accept-terms-of-use', [
                'terms' => Str::markdown(file_get_contents($termsFile)),
            ]);
        } elseif (! $request->user()->hasProvidedApiUseFields()) {
            return view('api.provide-additional-user-fields', [
                'terms' => Str::markdown(file_get_contents($termsFile)),
            ]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Process form.
     */
    public function acceptsTerms(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $user->accepted_api_terms = true;
        $user->save();

        $home = session('url.intended') ?? '/';

        return redirect()->route('dashboard');
    }

    /**
     * Process form.
     */
    public function provideAdditionalFields(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization' => 'sometimes|max:150',
            'proposed_use' => 'required|max:2000',
        ]);

        $user = Auth::user();
        $user->organization_name = $validated['organization'];
        $user->proposed_use = $validated['proposed_use'];
        $user->provided_api_fields = true;
        $user->save();

        $home = session('url.intended') ?? '/';

        return redirect()->route('dashboard');
    }
}
