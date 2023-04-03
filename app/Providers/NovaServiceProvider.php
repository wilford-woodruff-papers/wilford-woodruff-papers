<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Dashboards\Main;
use App\Nova\Metrics\NewPages;
use App\Nova\Metrics\PublishedItems;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        Nova::withBreadcrumbs();

        $this->app->register(\Parental\Providers\NovaResourceProvider::class);
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, User::role(['Editor', 'Admin', 'Super Admin'])->pluck('email')->all());
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     */
    protected function cards(): array
    {
        return [
            new PublishedItems(),
            new NewPages(),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     */
    protected function dashboards(): array
    {
        return [
            new Main(),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     */
    public function tools(): array
    {
        return [
            \JeffersonSimaoGoncalves\NovaPermission\NovaPermissionTool::make(),
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
