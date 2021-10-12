<?php

namespace App\Providers;

use App\Modules\Contact\Providers\ContactServiceProvider;
use App\Modules\Links\Providers\LinksServiceProvider;
use App\Modules\Projects\Providers\ProjectsServiceProvider;
use App\Modules\SiteMenus\Providers\SiteMenusServiceProvider;
use App\Modules\Technology\Providers\TechnologyServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->get('view')->addNamespace('errors', $this->app->basePath('templates/errors'));
        $this->app->get('view')->addNamespace('App', $this->app->basePath('templates/app'));
        $this->app->register(ContactServiceProvider::class);
        $this->app->register(LinksServiceProvider::class);
        $this->app->register(ProjectsServiceProvider::class);
        $this->app->register(SiteMenusServiceProvider::class);
        $this->app->register(TechnologyServiceProvider::class);

        if ($this->app->environment('local')) {
            //$this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
