<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;

/**
 * This runs the full migration suite
 * Favour "Illuminate\Foundation\Testing\RefreshDatabase"
 * where the full database doe nto require simulating
 */
trait DatabaseSetupTrait
{
    public function databaseSetUp(): void
    {
        Artisan::call('migrate --force --database=mysql_testing');
    }

    public function databaseTearDown(): void
    {
        Artisan::call('migrate:rollback --force --database=mysql_testing');
    }
}
