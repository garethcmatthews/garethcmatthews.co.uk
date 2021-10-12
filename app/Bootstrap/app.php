<?php

/**
 * garethcmatthews.co.uk
 *
 * Laravel can sometimes be a PITA - The main app bootstrap has been moved
 * to the src/Bootstrapper class, sadly there are at least 3 hard dependencies
 * on app.php within the laravel framework codebase so this is here
 * as a 'catchall'
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

return App\Bootstrap\Bootstrapper::getInstance()->getApp(realpath(__DIR__ . '/../../'));
