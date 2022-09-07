<?php

namespace App\Providers;

use App\Models\ContestSubmission;
use App\Models\Item;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Press;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });

        Route::bind('item', function ($item) {
            return Item::whereUuid($item)->first();
        });

        Route::bind('page', function ($page) {
            return Page::whereUuid($page)->first();
        });

        Route::bind('photo', function ($photo) {
            return Photo::whereUuid($photo)->first();
        });

        Route::bind('article', function ($article) {
            if (is_numeric($article)) {
                return Press::where('id', $article)->first();
            }

            return Press::where('slug', $article)->first();
        });

        Route::bind('submission', function ($submission) {
            return ContestSubmission::whereUuid($submission->first());
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
