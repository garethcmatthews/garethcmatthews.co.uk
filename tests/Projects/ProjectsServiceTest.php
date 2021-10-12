<?php

declare(strict_types=1);

namespace SiteMenus\Feature;

use App\Modules\Projects\ProjectsService;
use Database\Factories\ProjectsModelFactory;
use Illuminate\Cache\CacheManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class ProjectsServiceTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /**
     * ProjectsService::getProjects()
     * Ensure that the project items are returned
     *
     * Setup 1 item with 2 related technology records
     *
     * Expect 2 Technology Items
     */
    public function testGetProjects(): void
    {
        $expectTotal = 10;
        $service     = $this->app->get(ProjectsService::class);
        ProjectsModelFactory::new()
            ->count(10)
            ->create();

        $results = $service->getProjects();

        $this->assertIsArray($results);
        $this->assertCount($expectTotal, $results);
    }

    /**
     * ProjectsService::getProjects()
     * Check that the cache is called
     */
    public function testGetProjects_CacheIsCalled(): void
    {
        $mock = $this->getMockBuilder(CacheManager::class)
            ->disableOriginalConstructor()
            ->addMethods(['remember'])
            ->getMock();
        $mock->expects($this->once())->method('remember')
            ->with()
            ->willReturn([]);
        $this->instance('cache', $mock);

        $service = $this->app->get(ProjectsService::class);
        $service->getProjects();
    }
}
