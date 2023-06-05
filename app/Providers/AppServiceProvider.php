<?php

namespace App\Providers;

use App\Mixins\AddScriptureLinks;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Stringable::macro('addScriptureLinks', app(AddScriptureLinks::class)());

        if (! app()->environment('production')) {
            Mail::alwaysTo('test@wilfordwoodruffpapers.org');
        }
    }
}
