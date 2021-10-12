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
 * Laravel Telescope Helper
 *
 * Clear all entries from Telescope                - telescope:clear
 * Install all of the Telescope resources          - telescope:install
 * Prune stale entries from the Telescope database - telescope:prune
 * Publish all of the Telescope resources          - telescope:publish
 */
class TelescopeCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:telescope';

    /** @var string */
    protected $description = 'Application Helpers > Laravel Telescope';

    /** @var array */
    protected $commands = [
        1 => [
            'title'   => 'Install all of the Telescope resources',
            'command' => 'telescope:install',
        ],
        2 => [
            'title'   => 'Publish all of the Telescope resources',
            'command' => 'telescope:publish',
        ],
        3 => [
            'title'   => 'Prune stale entries from the Telescope database',
            'command' => 'telescope:prune',
        ],
        4 => [
            'title'   => 'Clear all entries from Telescope',
            'command' => 'telescope:clear',
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
            $this->line(shell_exec("php artisan $command") ?? '');
            $this->renderDividerBar();
        }

        $this->clearConsole();
        return 0;
    }
}
