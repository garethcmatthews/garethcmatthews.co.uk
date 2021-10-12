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

use function array_keys;
use function is_string;
use function shell_exec;

/**
 * Code Quality Helper
 *
 * Generate Development CSS
 * Generate Development JS
 * Generate Production CSS
 * Generate Production JS
 */

class BuildToolsCommand extends Command
{
    use ConsoleCommandInputTrait;
    use ConsoleCommandOutputTrait;

    /** @var string */
    protected $signature = 'application:buildtools';

    /** @var string */
    protected $description = 'Application Helpers > Build Tools';

    /** @var array */
    protected $commands = [
        1 => [
            'title'    => 'Generate Development CSS',
            'command'  => 'npm run dev --build=development-css',
            'subtitle' => 'Generating Development CSS',
        ],
        2 => [
            'title'    => 'Generate Development JS',
            'command'  => 'npm run dev --build=development-js',
            'subtitle' => 'Generating Development JS',
        ],
        3 => [
            'title'    => 'Generate Production CSS',
            'command'  => 'npm run production --build=production-css',
            'subtitle' => 'Generating Production CSS',
        ],
        4 => [
            'title'    => 'Generate Production JS',
            'command'  => 'npm run production --build=production-js',
            'subtitle' => 'Generating Production JS',
        ],
    ];

    public function handle(): int
    {
        $this->initialiseCommandData();
        while (true) {
            $this->clearConsole()->renderTitleBar($this->description);
            $choice = $this->choice('Select action', $this->getChoices($this->commands));
            if (! is_string($choice) || $choice === 'x') {
                break;
            }

            $command = $this->commands[$choice]['command'];
            $this->clearConsole()->renderTitleBar("{$this->description} > <fg=green>{$this->commands[$choice]['subtitle']}</fg=green>");
            $this->info($command);
            $this->line(shell_exec($command) ?? '');
            $this->ask('Completed - Press enter to continue');
        }

        $this->clearConsole();
        return 0;
    }

    private function initialiseCommandData(): void
    {
        $subtitles = [
            1 => 'Generating CSS/JS (All)',
            2 => 'Generating CSS/JS (Main)',
            3 => 'Generating CSS/JS (Links)',
        ];

        foreach (array_keys($this->commands) as $index) {
            $this->commands[$index]['subtitle'] = $subtitles[$index] ?? '';
        }
    }
}
