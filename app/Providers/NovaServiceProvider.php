<?php

namespace App\Providers;

use App\Nova\Dashboards\Main;
use App\Nova\Metrics\NewPages;
use App\Nova\Metrics\PublishedItems;
use Illuminate\Http\Request;
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

        Nova::userTimezone(function (Request $request) {
            return $request->user()?->timezone ?? 'America/Denver';
        });
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
            return $user->hasAnyRole(['Editor', 'Admin', 'Super Admin']);
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
