<?php

declare(strict_types=1);

namespace SiteMenus\Feature;

use App\Modules\Technology\TechnologyService;
use Database\Factories\TechnologyItemsModelFactory;
use Database\Factories\TechnologyModelFactory;
use Illuminate\Cache\CacheManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class TechnologyServiceTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /**
     * TechnologyService::getTechnologies()
     * Ensure that the technology items are returned
     *
     * Setup 1 item with 2 related technology records
     *
     * Expect 2 Technology Items
     */
    public function testGetTechnologies_CheckItems(): void
    {
        $expectTotalTechnology      = 1;
        $expectTotalTechnologyItems = 2;
        $service                    = $this->app->get(TechnologyService::class);
        TechnologyModelFactory::new()
            ->has(TechnologyItemsModelFactory::new()->count(2), 'items')
            ->has(TechnologyItemsModelFactory::new()->inactive()->count(2), 'items')
            ->count(1)
            ->create();

        $results = $service->getTechnologies();

        $this->assertIsArray($results);
        $this->assertCount($expectTotalTechnology, $results);
    }

    /**
     * TechnologyService::getTechnologies()
     * Check that the cache is called
     */
    public function testGetTechnologies_CacheIsCalled(): void
    {
        $mock = $this->getMockBuilder(CacheManager::class)
            ->disableOriginalConstructor()
            ->addMethods(['remember'])
            ->getMock();
        $mock->expects($this->once())->method('remember')
            ->with()
            ->willReturn([]);
        $this->instance('cache', $mock);

        $service = $this->app->get(TechnologyService::class);
        $service->getTechnologies();
    }
}
