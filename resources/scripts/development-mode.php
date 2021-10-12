<?php

/**
 * garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

const LINE_WIDTH   = 78;
const PROJECT_NAME = 'garethcmatthews.co.uk';

chdir(__DIR__ . '/../../');

print "\033[2J\033[;H";
echo str_repeat("=", LINE_WIDTH) . "\n= Development Mode Helper\n" . str_repeat("=", LINE_WIDTH);
echo "\n\n";

$basePath = getcwd();
if (basename($basePath) !== PROJECT_NAME) {
    echo "\n*** ERROR: Incorrect project base path - Terminated ***\n\n";
    exit;
}

switch ($argv[1] ?? 'status') {
    case 'enable':
        echo colourise('green', 'Enabling Development mode...') . "\n\n";
        updateEnvFile($basePath, true);
        clearAllLaravelCaches();
        updateComposer(true);
        break;
    case 'disable':
        echo colourise('green', 'Disabling Development mode...') . "\n\n";
        updateEnvFile($basePath);
        optimiseLaravelCaches();
        updateComposer();
        break;
    case 'status':
        echo getDevelopmentStatus($basePath);

        break;
}

echo str_repeat("-", LINE_WIDTH);
echo "\nCompleted\n\n";

function clearAllLaravelCaches(): void
{
    echo colourise('green', 'Clearing Laravel Caches...') . "\n";
    $commands = ['cache:clear', 'clear-compiled', 'config:clear', 'route:clear', 'view:clear'];
    foreach ($commands as $command) {
        $output = null;
        $value  = null;
        exec('php artisan ' . $command, $output, $value);
        $message = $value === 0 && count($output) === 1 ? $output[0] : 'ERROR : ' . implode('-', $output);
        echo colourise('yellow', "[Status: ${value}]") . ' ' . colourise('white', $message) . "\n";
    }

    echo str_repeat("-", LINE_WIDTH) . "\n";
}

function colourise(string $colour, string $string): string
{
    $colours = [
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'white' => 97,
    ];

    $code = array_key_exists($colour, $colours) ? $colours[$colour] : 97;

    return "\033[{$code}m{$string}\033[0m";
}

function getDevelopmentStatus(string $basePath): void
{
    $status = 'Unknown';
    if ($env = @file_get_contents($basePath . DIRECTORY_SEPARATOR . '.env')) {
        if (strstr($env, 'APP_ENV=local')) {
            $status = 'Development Mode Enabled';
        } elseif (strstr($env, 'APP_ENV=production')) {
            $status = 'Development Mode Disabled';
        }
    }

    echo colourise('green', 'Development Status:') . " $status\n\n";
}

function updateComposer(bool $isDevelopmentMode = false): void
{
    echo colourise('green', 'Updating Composer...') . "\n\n";
    echo shell_exec('composer dump-autoload' . ($isDevelopmentMode ? '' : ' --optimize')) ?? '';
    echo str_repeat("-", LINE_WIDTH);
}

function updateEnvFile(string $basePath, bool $isDevelopmentMode = false): void
{
    echo "\n\033[32mUpdating Env file...\033[0m\n";

    $file = $basePath . DIRECTORY_SEPARATOR . '.env';
    if (!$env = @file_get_contents($file)) {
        colourise('red', 'ERROR: Failed to load env file') . "\n";
        return;
    }

    $env = preg_replace('/APP_ENV.*/', 'APP_ENV=' . ($isDevelopmentMode ? 'local' : 'production'), $env) ?? $env;
    $env = preg_replace('/APP_DEBUG.*/', 'APP_DEBUG=' . ($isDevelopmentMode ? 'true' : 'false'), $env) ?? $env;
    if (file_put_contents($file, $env) === false) {
        echo "ERROR: Failed to save env file\n";
        return;
    }

    echo "Env file has been updated\n";
}

function optimiseLaravelCaches(): void
{
    echo colourise('green', 'Optimising Laravel Caches') . "\n";
    echo shell_exec('php artisan optimize') ?? '';
    echo str_repeat("-", LINE_WIDTH) . "\n";
}
