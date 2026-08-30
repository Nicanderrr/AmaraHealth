<?php

namespace App\Providers;

use App\Models\AppSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('partials.page-header', function ($view) {
            $routeName = request()->route()?->getName();
            $settingKey = match (true) {
                request()->routeIs('articles.*') => 'page_hero_library_image',
                request()->routeIs('forum.*') => 'page_hero_forum_image',
                request()->routeIs('tracker.*') => 'page_hero_tracker_image',
                request()->routeIs('resources.*') => 'page_hero_resources_image',
                request()->routeIs('consultations.*', 'call-sessions.*') => 'page_hero_consultations_image',
                in_array($routeName, ['login', 'register'], true) => 'page_hero_account_image',
                $routeName === 'dashboard' => 'page_hero_dashboard_image',
                default => null,
            };

            $path = $settingKey ? AppSetting::getValue($settingKey) : null;

            $view->with('configuredHeroBackground', $path ? asset('storage/'.$path) : null);
        });
    }
}
