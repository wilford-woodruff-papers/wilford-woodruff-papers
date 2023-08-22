<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DownloadAIExperienceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {

            $file = config('wwp.ai_download_path');

            return response()->streamDownload(function () use ($file) {
                $stream = \Illuminate\Support\Facades\Storage::disk('spaces')
                    ->readStream($file);
                fpassthru($stream);
                fclose($stream);
            }, basename($file));
        }

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        activity('ai-experience')
            ->event('download')
            ->log('User downloaded the AI Experience.');

         $subscribeToConstantContactAction = new \App\Actions\SubscribeToConstantContactAction();
            $subscribeToConstantContactAction->execute([
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->first_name,
                'last_name' => auth()->user()->last_name,
            ],
                [
                    config('wwp.list_memberships.immersive_ai_experience'),
                ]
            );
    }
}
