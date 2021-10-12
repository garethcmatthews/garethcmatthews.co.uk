<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Illuminate\Foundation;

use Illuminate\Foundation\Application;

use function str_replace;

use const DIRECTORY_SEPARATOR;

/**
 * Laravel Application Overrides
 *
 * Laravel is a PITA sometimes
 * Some paths extend, some don't
 * Some can be overridden via Env file settings whilst others cannot
 *
 * Making 'hard' changes here helps me keep my sanity
 */
class ApplicationOverrides extends Application
{
    /** @var string */
    private $bootstrapCache = '';

    public function __construct(?string $basePath = null)
    {
        parent::__construct($basePath);
        $this->bootstrapCache = $this->storagePath() . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'bootstrap';
    }

    /**
     * Bootstrap path
     *
     * @param string $path
     * @return string
     */
    public function bootstrapPath($path = ''): string
    {
        return $this->basePath . str_replace('/', DIRECTORY_SEPARATOR, '/app/Bootstrap') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function getCachedServicesPath(): string
    {
        return $this->bootstrapCache . DIRECTORY_SEPARATOR . 'services.php';
    }

    public function getCachedPackagesPath(): string
    {
        return $this->bootstrapCache . DIRECTORY_SEPARATOR . 'packages.php';
    }

    public function getCachedConfigPath(): string
    {
        return $this->bootstrapCache . DIRECTORY_SEPARATOR . 'config.php';
    }

    public function getCachedRoutesPath(): string
    {
        return $this->bootstrapCache . DIRECTORY_SEPARATOR . 'routes-v7.php';
    }

    public function getCachedEventsPath(): string
    {
        return $this->bootstrapCache . DIRECTORY_SEPARATOR . 'events.php';
    }
}
