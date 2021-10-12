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

use App\Modules\Console\Application\SettingsCommand;
use App\Modules\Console\ConsoleCommandInputTrait;
use App\Modules\Console\ConsoleCommandOutputTrait;
use Illuminate\Console\Command;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

use function is_string;

/**
 * Development Helpers - Main Menu
 * Wrapper menu for all the Development Helpers
 *
 * Application Information
 * Cache Management
 * Routes Management
 * Composer Management
 * Code Quality Tools
 * Build Tools
 * Database Migration Tools
 * Laravel Telescope Tools
 */
class ApplicationCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:menu';

    /** @var string */
    protected $description = 'Application Helpers';

    /** @var array */
    protected $commands = [
        1 => [
            'title'   => 'Application Settings',
            'command' => 'application:settings',
            'class'   => SettingsCommand::class,
        ],
        2 => [
            'title'   => 'Cache Management',
            'command' => 'application:cachemanagement',
            'class'   => CacheManagementCommand::class,
        ],
        3 => [
            'title'   => 'Routes Management',
            'command' => 'application:routes',
            'class'   => RoutesCommand::class,
        ],
        4 => [
            'title'   => 'Composer Management',
            'command' => 'application:composer',
            'class'   => ComposerCommand::class,
        ],
        5 => [
            'title'   => 'Code Quality Tools',
            'command' => 'application:codequality',
            'class'   => CodeQualityCommand::class,
        ],
        6 => [
            'title'   => 'Build Tools',
            'command' => 'application:buildtools',
            'class'   => BuildToolsCommand::class,
        ],
        7 => [
            'title'   => 'Database Migration Tools',
            'command' => 'application:database',
            'class'   => DatabaseCommand::class,
        ],
        8 => [
            'title'   => 'Laravel Telescope Tools',
            'command' => 'application:telescope',
            'class'   => TelescopeCommand::class,
        ],
    ];

    public function handle(): int
    {
        $this->registerLoaders();
        while (true) {
            $this->clearConsole()->renderTitleBar($this->description);
            $choice = $this->choice('Select action', $this->getChoices($this->commands));
            if (! is_string($choice) || $choice === 'x') {
                break;
            }

            $command = $this->commands[$choice]['command'];
            $this->clearConsole()->renderTitleBar("{$this->description} > <fg=green>Running: $command</fg=green>");
            $this->call($command);
            $this->renderDividerBar();
        }

        $this->clearConsole();
        return 0;
    }

    private function registerLoaders(): void
    {
        $data = [];
        foreach ($this->commands as $command) {
            $class                     = $command['class'];
            $data[$command['command']] = function () use ($class) {
                return new $class();
            };
        }

        if ($app = $this->getApplication()) {
            $app->setCommandLoader(new FactoryCommandLoader($data));
        }
    }
}
