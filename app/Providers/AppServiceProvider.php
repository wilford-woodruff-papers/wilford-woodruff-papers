<?php

namespace App\Providers;

use App\Http\Middleware\DownloadAIExperienceMiddleware;
use App\Macros\AddSubjectLinks;
use App\Macros\RemoveQZCodes;
use App\Macros\Stringable\ClearText;
use App\Macros\StripBracketedID;
use App\Models\ContestSubmission;
use App\Models\Item;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Press;
use App\Models\User;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        $this->app->singleton(DownloadAIExperienceMiddleware::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Stringable::macro('addSubjectLinks', app(AddSubjectLinks::class)());
        Str::macro('addScriptureLinks', app(\App\Macros\Str\AddScriptureLinks::class)());
        Stringable::macro('clearText', app(ClearText::class)());
        Str::macro('clearText', app(\App\Macros\Str\ClearText::class)());
        Stringable::macro('addScriptureLinks', app(\App\Macros\Stringable\AddScriptureLinks::class)());
        Str::macro('extractContentOnDate', app(\App\Macros\Str\ExtractContentOnDate::class)());
        Stringable::macro('extractContentOnDate', app(\App\Macros\Stringable\ExtractContentOnDate::class)());
        Str::macro('removeSubjectTags', app(\App\Macros\Str\RemoveSubjectTags::class)());
        Stringable::macro('removeSubjectTags', app(\App\Macros\Stringable\RemoveSubjectTags::class)());
        Stringable::macro('removeQZCodes', app(RemoveQZCodes::class)());
        Stringable::macro('stripBracketedID', app(StripBracketedID::class)());
        Str::macro('stripLanguageTag', app(\App\Macros\Str\StripLanguageTag::class)());
        Stringable::macro('stripLanguageTag', app(\App\Macros\Stringable\StripLanguageTag::class)());
        Str::macro('replaceInlineLanguageTags', app(\App\Macros\Str\ReplaceInlineLanguageTags::class)());
        Stringable::macro('replaceInlineLanguageTags', app(\App\Macros\Stringable\ReplaceInlineLanguageTags::class)());
        Str::macro('replaceFigureTags', app(\App\Macros\Str\ReplaceFigureTags::class)());
        Stringable::macro('replaceFigureTags', app(\App\Macros\Stringable\ReplaceFigureTags::class)());

        if (! app()->environment('production')) {
            Mail::alwaysTo('jon.fackrell@wilfordwoodruffpapers.org');
        }

        Validator::extend('exclude_one', function ($attribute, $value, $parameters, $validator) {
            return $value != 1;
        });

        RateLimiter::for('relationships', function ($job) {
            return Limit::perMinute(150);
        });

        if (app()->environment('production')) {
            FilamentAsset::register([
                Css::make('admin-css', Vite::useHotFile('vite.hot')
                    ->asset('resources/css/app.css', 'build')),
            ]);
        }

        Model::preventLazyLoading(! $this->app->isProduction());
        //Model::preventAccessingMissingAttributes(! $this->app->isProduction());

        $this->bootAuth();
        $this->bootRoute();
    }

    public function bootAuth(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->hasAnyRole('Super Admin');
        });
    }

    public function bootRoute(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Route::bind('item', function ($item) {
            return Item::whereUuid($item)->first();
        });

        Route::bind('identification', function ($item) {
            return \App\Models\Identification::findOrFail($item);
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
            return ContestSubmission::whereUuid($submission)->first();
        });
    }
}
