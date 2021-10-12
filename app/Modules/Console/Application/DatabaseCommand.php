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
 * Database Helpers
 *
 * migrate:fresh    - Drop all tables and re-run all migrations
 * migrate:install  - Create the migration repository
 * migrate:refresh  - Reset and re-run all migrations
 * migrate:reset    - Rollback all database migrations
 * migrate:rollback - Rollback the last database migration
 * migrate:status   - Show the status of each migration
 */
class DatabaseCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:database';

    /** @var string */
    protected $description = 'Application Helpers > Database migration tools';

    /** @var array */
    protected $commands = [
        1 => [
            'title'   => 'migrate:fresh    - Drop all tables and re-run all migrations',
            'command' => 'migrate:fresh',
        ],
        2 => [
            'title'   => 'migrate:install  - Create the migration repository',
            'command' => 'migrate:install',
        ],
        3 => [
            'title'   => 'migrate:refresh  - Reset and re-run all migrations',
            'command' => 'migrate:refresh',
        ],
        4 => [
            'title'   => 'migrate:reset    - Rollback all database migrations',
            'command' => 'migrate:reset',
        ],
        5 => [
            'title'   => 'migrate:rollback - Rollback the last database migration',
            'command' => 'migrate:rollback',
        ],
        6 => [
            'title'   => 'migrate:status   - Show the status of each migration',
            'command' => 'migrate:status',
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
