<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;

class AcceptTermsOfUseController extends Controller
{
    /**
     * Show form.
     *
     * @return \Illuminate\Http\Response
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
     *
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $user->accepted_terms = 1;
        $user->save();

        $home = session('url.intended') ?? '/';

        return redirect()->intended($home);
    }
}
