<?php

namespace Tests;

use App\Bootstrap\Bootstrapper;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

use function realpath;

trait CreateApplicationTrait
{
    public function createApplication(): Application
    {
        $app = Bootstrapper::getInstance()->getApp(realpath(__DIR__ . '/../'));
        $app->make(Kernel::class)->bootstrap();
        $this->clearCaches();

        return $app;
    }

    private function clearCaches(): void
    {
        $commands = ['cache:clear', 'clear-compiled', 'config:clear', 'route:clear', 'view:clear'];
        foreach ($commands as $command) {
            Artisan::call($command);
        }
    }
}
