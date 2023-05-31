<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Jetstream\Jetstream;

class AcceptApiTermsController extends Controller
{
    /**
     * Show form.
     */
    public function show(): View
    {
        $termsFile = Jetstream::localizedMarkdownPath('api-terms.md');

        return view('api.accept-terms-of-use', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }

    /**
     * Process form.
     */
    public function submit(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $user->accepted_api_terms = true;
        $user->save();

        $home = session('url.intended') ?? '/';

        return redirect()->intended($home);
    }
}
