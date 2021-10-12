<?php

namespace App\Providers;

use App\Http\Controllers\Actions\IndexAction;
use App\Http\Controllers\Actions\LinksAction;
use App\Http\Controllers\Actions\ProjectsAction;
use App\Http\Controllers\ContactsController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
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
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::get('/contact', [ContactsController::class, 'index'])->name('contact')->middleware(['forms']);
        Route::post('/contact', [ContactsController::class, 'store'])->name('contact.store')->middleware(['forms']);

        Route::get('/', IndexAction::class)->name('homepage')->middleware('web');
        Route::get('/links/{section?}', LinksAction::class)->name('links')->middleware('web');
        Route::get('/projects', ProjectsAction::class)->name('projects')->middleware('web');
    }
}
