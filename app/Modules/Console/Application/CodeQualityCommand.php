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
 * Code Quality Helper
 *
 * Run CS-Checker
 * Run CS-Fixer
 * Run PHPStan
 * Run Tests
 * Run Tests and generate coverage report
 */
class CodeQualityCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:codequality';

    /** @var string */
    protected $description = 'Application Helpers > Code quality tools';

    /** @var array */
    protected $commands = [];

    public function handle(): int
    {
        $this->initialiseCommandData();
        $this->clearConsole()->renderTitleBar($this->description);
        while (true) {
            $choice = $this->choice('Select action', $this->getChoices($this->commands));
            if (! is_string($choice) || $choice === 'x') {
                break;
            }

            $this->clearConsole()->renderTitleBar("{$this->description} > <fg=green>{$this->commands[$choice]['subtitle']}</fg=green>");
            $this->line(shell_exec($this->commands[$choice]['command']) ?? $this->commands[$choice]['error']);
            $this->renderDividerBar();
        }

        $this->clearConsole();
        return 0;
    }

    private function initialiseCommandData(): void
    {
        $basePath        = $this->getLaravel()->basePath();
        $storagePath     = $this->getLaravel()->storagePath();
        $vendorBinFolder = $this->getLaravel()->basePath() . '/vendor/bin';

        $this->commands = [
            1 => [
                'title'    => 'Run CS-Checker',
                'subtitle' => 'Running CS-Checker',
                'command'  => "$vendorBinFolder/phpcs -s",
                'error'    => "\nNo Errors found\n",
            ],
            2 => [
                'title'    => 'Run CS-Fixer',
                'subtitle' => 'Running CS-Fixer',
                'command'  => "$vendorBinFolder/phpcbf",
                'error'    => '',
            ],
            3 => [
                'title'    => 'Run PHPStan',
                'subtitle' => 'Running PHP Static Analyser',
                'command'  => "$vendorBinFolder/phpstan analyse -c $basePath/phpstan.neon.dist --memory-limit 1G",
                'error'    => '',
            ],
            4 => [
                'title'    => 'Run Tests',
                'subtitle' => 'Running PHPUnit',
                'command'  => "$vendorBinFolder/phpunit -c $basePath/phpunit.xml.dist",
                'error'    => '',
            ],
            5 => [
                'title'    => 'Run Tests and generate coverage report',
                'subtitle' => 'Running PHPUnit Code Coverage',
                'command'  => "$vendorBinFolder/phpunit -c $basePath/phpunit.xml.dist --coverage-html $storagePath/temp/tests-coverage-report",
                'error'    => '',
            ],
        ];
    }
}
