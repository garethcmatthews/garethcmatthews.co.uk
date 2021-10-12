<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace App\Modules\Technology\Providers;

use Illuminate\Support\ServiceProvider;

class TechnologyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $path = $this->app->get('app')->basePath('templates/modules/technology');
        $this->app->get('view')->addNamespace('Technology', $path);
    }
}
