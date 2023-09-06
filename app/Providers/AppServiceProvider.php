<?php

namespace App\Providers;

use App\Http\Middleware\DownloadAIExperienceMiddleware;
use App\Macros\AddSubjectLinks;
use App\Macros\RemoveQZCodes;
use App\Macros\StripBracketedID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
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

        Model::preventLazyLoading(! $this->app->isProduction());
        Model::preventAccessingMissingAttributes(! $this->app->isProduction());
    }
}
