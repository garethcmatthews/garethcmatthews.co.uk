<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link      https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright Copyright (c) Gareth C Matthews
 * @license   https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Kernel;

use App\Modules\Console\Application\ApplicationCommand;
use Illuminate\Foundation\Console\Kernel;

class ConsoleKernel extends Kernel
{
    /** @var array */
    protected $commands = [ApplicationCommand::class];
}
