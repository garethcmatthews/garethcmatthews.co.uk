<?php

/**
 * garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Console;

/**
 * Console Commands - Console Input Helpers
 *
 * Get Choices - Extract choices from command array
 */
trait ConsoleCommandInputTrait
{
    private function getChoices(array $commands = []): array
    {
        $data = [];
        foreach ($commands as $index => $values) {
            $data[$index] = $values['title'];
        }

        $data['x'] = 'Exit';
        return $data;
    }
}
