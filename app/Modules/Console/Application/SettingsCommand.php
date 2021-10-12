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

use function basename;
use function count;
use function exec;
use function explode;
use function glob;
use function implode;
use function is_file;
use function is_string;
use function shell_exec;
use function sort;

/**
 * Application Settings Helper
 *
 * Application - Show Details
 * Application - Providers
 * Application - Aliases
 * Cache       - Optimise all
 * Cache       - Clear all Caches
 * Database    - Create Application
 * Database    - Destroy Application
 */
class SettingsCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:settings';

    /** @var string */
    protected $description = 'Application Helpers > Settings';

    /** @var int */
    protected $consoleLineWidth = 90;

    /** @var array */
    protected $commands = [
        1 => [
            'title'    => 'Application - Show Details',
            'command'  => '',
            'subtitle' => 'Application Details',
        ],
        2 => [
            'title'    => 'Application - Show Providers',
            'command'  => '',
            'subtitle' => 'Application Service Providers',
        ],
        3 => [
            'title'    => 'Application - Show Aliases',
            'command'  => '',
            'subtitle' => 'Application Aliases',
        ],
        4 => [
            'title'    => 'Cache       - Optimise all',
            'command'  => '',
            'subtitle' => 'Optimise All',
        ],
        5 => [
            'title'    => 'Cache       - Clear all Caches',
            'command'  => '',
            'subtitle' => 'Clearing Laravel Caches',
        ],
        6 => [
            'title'    => 'Database    - Create Application',
            'command'  => '',
            'subtitle' => 'Create Database',
        ],
        7 => [
            'title'    => 'Database    - Destroy Application',
            'command'  => '',
            'subtitle' => 'Destroy Test Database',
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

            $this->clearConsole()->renderTitleBar("{$this->description} > <fg=green>{$this->commands[$choice]['subtitle']}</fg=green>");
            switch ($choice) {
                case '1':
                    $this->renderApplicationDetails();
                    $this->renderDividerBar();
                    break;
                case '2':
                    $this->renderApplicationServiceProviders();
                    $this->renderDividerBar();
                    break;
                case '3':
                    $this->renderApplicationAliases();
                    $this->renderDividerBar();
                    break;
                case '4':
                    $this->line(shell_exec('php artisan optimize') ?? '');
                    $this->renderDividerBar();
                    break;
                case '5':
                    $this->clearAllLaravelCaches();
                    $this->renderDividerBar();
                    break;
                case '6':
                    $this->info("Migrating Database");
                    $this->line(shell_exec("php artisan migrate --force --database=mysql") ?? '');
                    $this->runDatabaseSeeders();
                    $this->ask('Migration Completed - Press enter to continue');
                    $this->clearConsole()->renderTitleBar($this->description);
                    break;
                case '7':
                    $this->info("Destroying Database");
                    $this->line(shell_exec("php artisan migrate:rollback --force --database=mysql") ?? '');
                    $this->ask('Migration Rollback Completed - Press enter to continue');
                    $this->clearConsole()->renderTitleBar($this->description);
                    break;
            }
        }

        $this->clearConsole();
        return 0;
    }

    private function renderApplicationDetails(): void
    {
        $config = $this->getLaravel()->get('config')->get('app');
        $data   = [
            'Application:'      => [
                ['Laravel Version:', $this->getLaravel()->version()],
                ['Environment:', $config['env']],
                ['Debug enabled:', $config['debug'] ? 'yes' : 'no'],
                ['Dev Mode:', $config['env'] === 'local' ? 'yes' : 'no'],
            ],
            'Timezone/Locales:' => [
                ['Timezone:', $config['timezone']],
                ['Locale:', $config['locale']],
                ['Locale Fallback:', $config['fallback_locale']],
                ['Locale Faker:', $config['faker_locale']],
            ],
            'Security:'         => [
                ['Key:', $config['key']],
                ['Cipher:', $config['cipher']],
            ],
        ];

        foreach ($data as $title => $section) {
            $this->info(' ' . $title);
            $this->table([], $section, 'compact');
            $this->newLine();
        }
    }

    private function renderApplicationServiceProviders(): void
    {
        $providers = $this->getLaravel()->get('config')->get('app')['providers'] ?? [];
        sort($providers);

        $currentGroup = '';
        foreach ($providers as $provider) {
            $group = explode("\\", $provider, 2)[0];
            if ($group !== $currentGroup) {
                if (empty($currentGroup) === false) {
                    $this->renderDividerBar();
                }
                $currentGroup = $group;
            }

            $this->line($provider);
        }
    }

    private function renderApplicationAliases(): void
    {
        $data    = [];
        $aliases = $this->getLaravel()->get('config')->get('app')['aliases'] ?? [];
        foreach ($aliases as $key => $value) {
            $data[] = [$key, " => $value"];
        }

        $this->table([], $data, 'compact');
    }

    private function clearAllLaravelCaches(): void
    {
        foreach (['cache:clear', 'clear-compiled', 'config:clear', 'route:clear', 'view:clear'] as $command) {
            $output = null;
            $value  = null;
            exec('php artisan ' . $command, $output, $value);
            $message = $value === 0 && count($output) === 1 ? $output[0] : 'ERROR : ' . implode('-', $output);
            $this->info("[Status: ${value}] - ${message}");
        }
    }

    private function runDatabaseSeeders(string $database = 'mysql'): void
    {
        if (! $filenames = glob($this->getLaravel()->databasePath('seeders') . '/*')) {
            return;
        }

        foreach ($filenames as $filename) {
            if (is_file($filename)) {
                $seeder = 'Database\\Seeders\\' . basename($filename, '.php');
                echo $seeder . "\n";
                echo shell_exec('php artisan db:seed --force --database=' . $database . ' --class="' . $seeder . '"');
            }
        }
    }
}
