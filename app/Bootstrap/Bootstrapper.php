<?php

/**
 * garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Bootstrap;

use App\Exceptions\ApplicationExceptionHandler;
use App\Illuminate\Foundation\ApplicationOverrides;
use App\Kernel\ConsoleKernel;
use App\Kernel\HttpKernel;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

class Bootstrapper
{
    /** @var App\Booststrap\Bootstrapper */
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(): Bootstrapper
    {
        if (! isset(self::$instance)) {
            self::$instance = new Bootstrapper();
        }

        return self::$instance;
    }

    public function getApp(string $basePath = ''): ApplicationOverrides
    {
        $app = new ApplicationOverrides($basePath);

        $app->singleton(Kernel::class, HttpKernel::class);
        $app->singleton(\Illuminate\Contracts\Console\Kernel::class, ConsoleKernel::class);
        $app->singleton(ExceptionHandler::class, ApplicationExceptionHandler::class);

        $app->useDatabasePath($app->resourcePath('database'))
            ->useLangPath($app->basePath('translations'));

        return $app;
    }

    public function run(string $basePath = ''): void
    {
        $app = $this->getApp($basePath);

        $kernel = $app->make(Kernel::class);

        $response = $kernel->handle($request = Request::capture());
        $response->send();

        $kernel->terminate($request, $response);
    }
}
