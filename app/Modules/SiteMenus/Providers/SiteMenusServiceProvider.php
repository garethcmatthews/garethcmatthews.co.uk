<?php

namespace App\Modules\SiteMenus\Providers;

use App\Modules\SiteMenus\Components\SiteNavigationComponent;
use Illuminate\Support\ServiceProvider;

class SiteMenusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->get('view')->addNamespace('SiteMenus', $this->app->basePath('templates/modules/site-menus'));
        $this->app->get('blade.compiler')->component('site-navigation', SiteNavigationComponent::class);
    }
}
