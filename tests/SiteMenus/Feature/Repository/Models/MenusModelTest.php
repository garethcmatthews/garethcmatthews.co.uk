<?php

declare(strict_types=1);

namespace SiteMenus\Feature\Repository\Model;

use App\Modules\SiteMenus\Repository\Models\MenusModel;
use Database\Factories\MenuItemsModelFactory;
use Database\Factories\MenusModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class MenusModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'menus';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = ['id', 'name', 'active', 'created_at', 'updated_at'];
        $model    = new MenusModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEqualsCanonicalizing($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $total = 1;
        $model = new MenusModel();
        MenusModelFactory::new()
            ->count(1)
            ->create();

        $this->assertEquals($this->tablename, $model->getTable());
        $this->assertEquals($total, $model->get()->count());
    }

    /**
     * Test model relationships
     */
    public function test_HasMany(): void
    {
        $total = 1;
        $model = new MenusModel();
        MenusModelFactory::new()
            ->has(MenuItemsModelFactory::new()->count(1), 'items')
            ->count(1)
            ->create();

        $this->assertEquals($total, $model->first()->items->count());
    }
}
