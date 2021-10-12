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

print "\033[2J\033[;H";
echo str_repeat("=", LINE_WIDTH);
echo "\n= Creating Missing Storage folders\n";
echo str_repeat("=", LINE_WIDTH);
echo "\n";

chdir(__DIR__ . '/../../');

$basePath = getcwd();
if (basename($basePath) !== PROJECT_NAME) {
    echo "\n*** ERROR: Incorrect project base path - Terminated ***\n\n";
    exit;
}

$folders = [
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/cache',
    'storage/cache/bootstrap',
    'storage/cache/data',
    'storage/cache/views',
    'storage/logs',
    'storage/sessions',
    'storage/temp',
    'storage/temp/tests-coverage-report',
];

foreach ($folders as $folder) {
    $path = $basePath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $folder);
    if (file_exists($path) === false) {
        echo mkdir($path) ? "Added  - ${path}\n" : '';
    } else {
        echo "Exists - ${path}\n";
    }
}

echo str_repeat("-", LINE_WIDTH);
echo "\nCompleted\n\n";
