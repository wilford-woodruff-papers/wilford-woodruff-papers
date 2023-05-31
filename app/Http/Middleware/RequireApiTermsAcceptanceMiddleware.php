<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RequireApiTermsAcceptanceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        session(['url.intended' => Route::currentRouteName()]);

        if (! $request->user()->hasAcceptedApiTerms()) {
            return redirect()->route('api.terms.accept');
        }

        return $next($request);
    }
}
