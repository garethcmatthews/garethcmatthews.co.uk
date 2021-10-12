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
 * Application Routes Helper
 *
 * route:list  - List all registered routes
 * route:list  - List all registered routes (compact)
 * route:list  - List all registered routes (method,uri,name,action)
 * route:cache - Create a route cache file for faster route registration
 * route:clear - Remove the route cache file
 */
class RoutesCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:routes';

    /** @var string */
    protected $description = 'Application Helpers > Routes';

    /** @var int */
    protected $consoleLineWidth = 86;

    /** @var array */
    protected $commands = [
        1 => [
            'title'   => 'route:list  - List all registered routes',
            'command' => 'route:list',
        ],
        2 => [
            'title'   => 'route:list  - List all registered routes (compact)',
            'command' => 'route:list -c',
        ],
        3 => [
            'title'   => 'route:list  - List all registered routes (method,uri,name,action)',
            'command' => 'route:list --columns method,uri,name,action',
        ],
        4 => [
            'title'   => 'route:cache - Create a route cache file for faster route registration',
            'command' => 'route:cache',
        ],
        5 => [
            'title'   => 'route:clear - Remove the route cache file',
            'command' => 'route:clear',
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
            $this->clearConsole()->renderTitleBar("{$this->description} > <fg=green>Running: $command</fg=green>", $this->consoleLineWidth);
            $this->line(shell_exec("php artisan $command") ?? '');
            $this->renderDividerBar($this->consoleLineWidth);
        }

        $this->clearConsole();
        return 0;
    }
}
