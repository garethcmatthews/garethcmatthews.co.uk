<?php

declare(strict_types=1);

namespace SiteMenus\Feature\Repository;

use App\Modules\SiteMenus\Repository\Models\MenuItemsModel;
use App\Modules\SiteMenus\Repository\SiteMenusRepository;
use Database\Factories\MenuItemsModelFactory;
use Database\Factories\MenusModelFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Collection;
use Tests\CreateApplicationTrait;

class SiteMenusRepositoryTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /**
     * SiteMenusRepository::fetchMenu()
     * No menus in database table
     *
     * Expect empty collection
     */
    public function testFetchMenus_NoDatabaseRecords(): void
    {
        $expectTotal = 0;
        $repository  = $this->app->get(SiteMenusRepository::class);

        $results = $repository->fetchMenu('dummy');

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
    }

    /**
     * SiteMenusRepository::fetchMenu()
     * No menus items in database table
     *
     * Expect empty collection
     */
    public function testFetchMenus_NoMenuItems(): void
    {
        $expectTotal = 0;
        $menu        = 'menu-1';
        $repository  = $this->app->get(SiteMenusRepository::class);
        MenusModelFactory::new()
            ->state(['name' => $menu])
            ->count(1)
            ->create();

        $results = $repository->fetchMenu($menu);

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
    }

    /**
     * SiteMenusRepository::fetchMenu()
     * Call to inactive menu
     *
     * Expect empty collection
     */
    public function testFetchMenus_InactiveMenu(): void
    {
        $expectTotal = 0;
        $menu        = "menu-1";
        $repository  = $this->app->get(SiteMenusRepository::class);
        MenusModelFactory::new()
            ->has(MenuItemsModelFactory::new()->count(2), 'items')
            ->state(['name' => $menu])
            ->count(1)
            ->inactive()
            ->create();

        $results = $repository->fetchMenu($menu);

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
    }

    /**
     * SiteMenusRepository::fetchMenu()
     * Missing Menu
     *
     * Setup 1 menu
     * Call non existant menu name
     *
     * Expect empty collection
     */
    public function testFetchMenus_MissingMenu(): void
    {
        $expectTotal = 0;
        $repository  = $this->app->get(SiteMenusRepository::class);
        MenusModelFactory::new()
            ->state(['name' => 'menu-1'])
            ->count(1)
            ->create();

        $results = $repository->fetchMenu('dummy');

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
    }

    /**
     * SiteMenusRepository::fetchMenu()
     * Should only return 'active' menu items
     *
     * Setup 1 Menu with 3 items, 1 item inactive
     *
     * Expect 2 Items with no children
     */
    public function testFetchMenu_MenuItemsActive(): void
    {
        $expectTotal = 2;
        $repository  = $this->app->get(SiteMenusRepository::class);
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

        $results = $repository->fetchMenu('menu-1');

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertInstanceOf(MenuItemsModel::class, $results[0]);
        $this->assertInstanceOf(MenuItemsModel::class, $results[1]);
        $this->assertEquals('menu-item1', $results[0]->title);
        $this->assertEquals('menu-item3', $results[1]->title);
        $this->assertNull($results[0]->children);
    }

    /**
     * SiteMenusRepository::fetchMenu()
     * Should return menu items in correct order
     *
     * Setup 1 Menu with 3 items, mixed sort order
     *
     * Expect 3 items in correct sort order with no children
     */
    public function testFetchMenu_MenuItemsSortOrder(): void
    {
        $expectTotal = 3;
        $repository  = $this->app->get(SiteMenusRepository::class);
        MenusModelFactory::new()
            ->count(1)
            ->state(['name' => 'menu-2'])
            ->has(
                MenuItemsModelFactory::new()
                    ->state(new Sequence(
                        ['menu_id' => 2, 'title' => 'menu-item1', 'orderby' => 3, 'active' => 1],
                        ['menu_id' => 2, 'title' => 'menu-item2', 'orderby' => 2, 'active' => 1],
                        ['menu_id' => 2, 'title' => 'menu-item3', 'orderby' => 1, 'active' => 1]
                    ))->count(3),
                'items'
            )->create();

        $results = $repository->fetchMenu('menu-2');

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($expectTotal, $results->count());
        $this->assertInstanceOf(MenuItemsModel::class, $results[0]);
        $this->assertInstanceOf(MenuItemsModel::class, $results[1]);
        $this->assertEquals('menu-item1', $results[2]->title);
        $this->assertEquals('menu-item2', $results[1]->title);
        $this->assertEquals('menu-item3', $results[0]->title);
        $this->assertNull($results[0]->children);
    }

    /**
     * SiteMenusRepository::fetchMenu()
     * Should return empty collection
     *
     * Setup 1 Menu with no links
     *
     * Expect empty collection
     */
    public function testFetchMenu_MenuItemsEmpty(): void
    {
        $repository = $this->app->get(SiteMenusRepository::class);
        MenusModelFactory::new()
            ->count(1)
            ->state(['name' => 'menu-1'])
            ->create();

        $results = $repository->fetchMenu('menu-1');

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEmpty($results);
    }

    /**
     * SiteMenusRepository::fetchMenu()
     * Get menu item with children items
     *
     * Setup 1 menu with 1 menu item with children of 2 menu items
     *
     * Expect 1 menu item with 2 child items
     */
    public function testFetchMenu_MenuItemWithChildren(): void
    {
        $repository = $this->app->get(SiteMenusRepository::class);
        MenusModelFactory::new()
            ->count(1)
            ->state(['id' => 1, 'name' => 'menu-1'])
            ->create();
        MenuItemsModelFactory::new()
            ->count(1)
            ->state(['id' => 1, 'menu_id' => 1])
            ->create();
        MenuItemsModelFactory::new()
            ->count(2)
            ->state(['parent_id' => 1, 'menu_id' => 1])
            ->create();

        $results = $repository->fetchMenu('menu-1');

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals(1, $results->count());
        $this->assertInstanceOf(MenuItemsModel::class, $results[0]);

        $this->assertEquals(2, $results[0]->children->count());
        foreach ($results[0]->children as $child) {
            $this->assertInstanceOf(MenuItemsModel::class, $child);
        }
    }
}
