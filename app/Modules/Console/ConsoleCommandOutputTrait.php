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

use function str_repeat;

/**
 * Console Commands - Console Output Helpers
 *
 * Clear Console
 * Render Title Bar
 * Render Divider Bar
 */
trait ConsoleCommandOutputTrait
{
    private function clearConsole(): self
    {
        // https://student.cs.uwaterloo.ca/~cs452/terminal.html
        print "\033[2J\033[;H";
        return $this;
    }

    private function renderTitleBar(string $title, int $lineWidth = 78): self
    {
        $this->line(str_repeat("=", $lineWidth));
        $this->line("= $title");
        $this->line(str_repeat("=", $lineWidth));
        $this->newLine();
        return $this;
    }

    private function renderDividerBar(int $lineWidth = 78): self
    {
        $this->line(str_repeat('-', $lineWidth));
        return $this;
    }
}
