<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RequireApiTermsAcceptanceMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        session(['url.intended' => Route::currentRouteName()]);

        if (! $request->user()->hasAcceptedApiTerms() || ! $request->user()->hasProvidedApiUseFields()) {
            return redirect()->route('api.terms.accept');
        }

        return $next($request);
    }
}
