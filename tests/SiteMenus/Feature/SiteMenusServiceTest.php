<?php

declare(strict_types=1);

namespace SiteMenus\Feature;

use App\Modules\SiteMenus\SiteMenusService;
use Database\Factories\MenuItemsModelFactory;
use Database\Factories\MenusModelFactory;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

use function array_keys;

class SiteMenusServiceTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /**
     * SiteMenusService::fetchMenu()
     * Should only return 'active' menu items
     *
     * Setup 1 Menu with 3 items, 1 item inactive
     *
     * Expect 2 Items with no children
     */
    public function testFetchMenu_MenuItemsActive(): void
    {
        $expectKeys  = [
            'id',
            'menu_id',
            'parent_id',
            'active',
            'orderby',
            'title',
            'routename',
            'parameters',
            'created_at',
            'updated_at',
            'children',
        ];
        $expectTotal = 2;
        $service     = $this->app->get(SiteMenusService::class);
        MenusModelFactory::new()
            ->count(1)
            ->state(['name' => 'menu-1'])
            ->has(
                MenuItemsModelFactory::new()
                    ->state(new Sequence(
                        ['menu_id' => 1, 'title' => 'menu-item1', 'orderby' => 1, 'active' => 1],
                        ['menu_id' => 1, 'title' => 'menu-item2', 'orderby' => 2, 'active' => 0],
                        ['menu_id' => 1, 'title' => 'menu-item3', 'orderby' => 3, 'active' => 1]
                    ))->count(3),
                'items'
            )->create();

        $results = $service->fetchMenu('menu-1');

        $this->assertIsArray($results);
        $this->assertCount($expectTotal, $results);
        $this->assertEquals($expectKeys, array_keys($results[0]));
        $this->assertEquals('menu-item1', $results[0]['title']);
        $this->assertEquals('menu-item3', $results[1]['title']);
        $this->assertNull($results[0]['children']);
    }

    /**
     * SiteMenusService::fetchMenu()
     * Check that the cache is called
     */
    public function testFetchAll_CacheIsCalled(): void
    {
        $mock = $this->getMockBuilder(CacheManager::class)
            ->disableOriginalConstructor()
            ->addMethods(['remember'])
            ->getMock();
        $mock->expects($this->once())->method('remember')
            ->with()
            ->willReturn([]);
        $this->instance('cache', $mock);

        $service = $this->app->get(SiteMenusService::class);
        $service->fetchMenu('menu-1');
    }
}
