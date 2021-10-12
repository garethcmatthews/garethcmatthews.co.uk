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
 * Application Cache Management
 *
 * config:cache - Create a cache file for faster configuration loading
 * route:cache  - Create a route cache file for faster route registration
 * view:cache   - Compile all of the applications Blade templates
 * cache:table  - Create a migration for the cache database table
 * cache:clear  - Flush the application cache
 * cache:forget - Remove an item from the cache
 * config:clear - Remove the configuration cache file
 * route:clear  - Remove the route cache file
 * view:clear   - Clear all compiled view files
 */
class CacheManagementCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:cachemanagement';

    /** @var string */
    protected $description = 'Application Helpers > Cache Management';

    /** @var array */
    protected $commands = [
        1 => [
            'title'   => 'config:cache - Create a cache file for faster configuration loading',
            'command' => 'config:cache',
        ],
        2 => [
            'title'   => 'route:cache  - Create a route cache file for faster route registration',
            'command' => 'route:cache',
        ],
        3 => [
            'title'   => 'view:cache   - Compile all of the applications Blade templates',
            'command' => 'view:cache',
        ],
        4 => [
            'title'   => 'cache:table  - Create a migration for the cache database table',
            'command' => 'cache:table',
        ],
        5 => [
            'title'   => 'cache:clear  - Flush the application cache',
            'command' => 'cache:clear',
        ],
        6 => [
            'title'   => 'cache:forget - Remove an item from the cache',
            'command' => 'cache:forget',
        ],
        7 => [
            'title'   => 'config:clear - Remove the configuration cache file',
            'command' => 'config:clear',
        ],
        8 => [
            'title'   => 'route:clear  - Remove the route cache file',
            'command' => 'route:clear',
        ],
        9 => [
            'title'   => 'view:clear   - Clear all compiled view files',
            'command' => 'view:clear',
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
            $action  = $choice === '6' ? $this->handleCacheForgetQuestions($command) : $command;
            $this->clearConsole()->renderTitleBar("{$this->description} > <fg=green>Running: $command</fg=green>");
            $this->line(shell_exec("php artisan $action") ?? '');
            $this->renderDividerBar();
        }

        $this->clearConsole();
        return 0;
    }

    private function handleCacheForgetQuestions(string $command): string
    {
        $key   = $this->ask('Cache Key to forget');
        $store = $this->ask('Cache Store', 'file');
        return "$command $key $store";
    }
}
