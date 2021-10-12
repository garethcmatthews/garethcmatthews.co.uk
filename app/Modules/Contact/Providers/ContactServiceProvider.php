<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace App\Modules\Contact\Providers;

use Illuminate\Support\ServiceProvider;

class ContactServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->get('view')->addNamespace('Contact', $this->app->get('app')->basePath('templates/modules/contact'));
    }
}
