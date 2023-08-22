<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
}
