<?php

namespace App\Providers;

use App\Http\Middleware\DownloadAIExperienceMiddleware;
use App\Macros\AddSubjectLinks;
use App\Macros\RemoveQZCodes;
use App\Macros\StripBracketedID;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
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
        Stringable::macro('addScriptureLinks', app(\App\Macros\Stringable\AddScriptureLinks::class)());
        Str::macro('extractContentOnDate', app(\App\Macros\Str\ExtractContentOnDate::class)());
        Stringable::macro('extractContentOnDate', app(\App\Macros\Stringable\ExtractContentOnDate::class)());
        Str::macro('removeSubjectTags', app(\App\Macros\Str\RemoveSubjectTags::class)());
        Stringable::macro('removeSubjectTags', app(\App\Macros\Stringable\RemoveSubjectTags::class)());
        Stringable::macro('removeQZCodes', app(RemoveQZCodes::class)());
        Stringable::macro('stripBracketedID', app(StripBracketedID::class)());
        Str::macro('stripLanguageTag', app(\App\Macros\Str\StripLanguageTag::class)());
        Stringable::macro('stripLanguageTag', app(\App\Macros\Stringable\StripLanguageTag::class)());

        if (! app()->environment('production')) {
            Mail::alwaysTo('test@wilfordwoodruffpapers.org');
        }

        Validator::extend('exclude_one', function ($attribute, $value, $parameters, $validator) {
            return $value != 1;
        });

        RateLimiter::for('relationships', function ($job) {
            return Limit::perMinute(150);
        });

        //Model::preventLazyLoading(! $this->app->isProduction());
        //Model::preventAccessingMissingAttributes(! $this->app->isProduction());
    }
}
