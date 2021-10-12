<?php

/**
 * garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Console\Application;

use App\Modules\Console\ConsoleCommandInputTrait;
use App\Modules\Console\ConsoleCommandOutputTrait;
use Illuminate\Console\Command;

use function is_string;
use function shell_exec;

/**
 * Composer Helper
 *
 * Dump Autoloader
 * Dump Autoloader Optimised
 */
class ComposerCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:composer';

    /** @var string */
    protected $description = 'Application Helpers > Composer';

    /** @var array */
    protected $commands = [
        1 => [
            'title'   => 'Dump autoloader',
            'command' => 'dump-autoload',
        ],
        2 => [
            'title'   => 'Dump autoloader optimised',
            'command' => 'dump-autoload --optimize',
        ],
    ];

    public function handle(): int
    {
        $this->clearConsole()->renderTitleBar($this->description);
        while (true) {
            $choice = $this->choice('Select action', $this->getChoices($this->commands));
            if (! is_string($choice) || $choice === 'x') {
                break;
            }

            $command = $this->commands[$choice]['command'];
            $this->clearConsole()->renderTitleBar("{$this->description} > <fg=green>Running: $command</fg=green>");
            $this->line(shell_exec("composer $command") ?? '');
            $this->renderDividerBar();
        }

        $this->clearConsole();
        return 0;
    }
}
