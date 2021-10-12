<?php

declare(strict_types=1);

namespace SiteMenus\Feature;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

use function is_int;

class TechnologyConfigurationTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    private const CACHE_TIMEOUT = 'modules.technology.model-cache-timeout';

    /**
     * Test that the required application configuration keys exist
     *
     * 'module-links.model-cache-timeout' [int|null]
     * 'module-links.paginator-records-per-page'    [int]
     */
    public function testConfigKeysExist(): void
    {
        $config = $this->app->get('config');
        $this->assertInstanceOf(Repository::class, $config);

        $this->assertTrue($config->has(self::CACHE_TIMEOUT));
        $this->assertTrue(
            null === $config->get(self::CACHE_TIMEOUT) ||
                is_int($config->get(self::CACHE_TIMEOUT))
        );
    }
}
