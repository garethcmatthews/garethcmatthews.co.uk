<?php

declare(strict_types=1);

namespace SiteMenus\Feature;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class ProjectsConfigurationTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    private const CACHE_TIMEOUT = 'modules.projects.model-cache-timeout';

    /**
     * Test that the required application configuration keys exist
     *
     * 'module-projects.model-cache-timeout' [int|null]
     */
    public function testConfigKeysExist(): void
    {
        $config = $this->app->get('config');
        $this->assertInstanceOf(Repository::class, $config);

        $this->assertTrue($config->has(self::CACHE_TIMEOUT));
    }
}
