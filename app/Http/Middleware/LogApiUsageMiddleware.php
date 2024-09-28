<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiUsageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        activity('api')
            ->event((str($request->path())->startsWith('api') ? 'accessed' : 'documentation'))
            ->withProperties(array_merge(
                [
                    'user_agent' => $request->server('HTTP_USER_AGENT'),
                    'ip' => $request->ip(),
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'status' => $response->status(),
                ],
                $request->only([
                    'types[',
                    'q',
                    'per_page',
                    'page',
                    'id',
                    'uuid',
                ])
            ))
            ->log($request->path());
    }
}
