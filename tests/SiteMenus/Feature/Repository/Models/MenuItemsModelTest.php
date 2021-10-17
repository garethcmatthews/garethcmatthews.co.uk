<?php

declare(strict_types=1);

namespace SiteMenus\Feature\Repository\Model;

use App\Modules\SiteMenus\Repository\Models\MenuItemsModel;
use Database\Factories\MenuItemsModelFactory;
use Database\Factories\MenusModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Collection;
use Tests\CreateApplicationTrait;
use TypeError;

class MenuItemsModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'menu_items';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = [
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
        ];
        $model    = new MenuItemsModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEqualsCanonicalizing($expected, $columns);
    }

    /**
     * Test Model Appends
     */
    public function testModelAttributes(): void
    {
        $expected = ['children'];
        $model    = new MenuItemsModel();

        foreach ($expected as $expect) {
            $this->assertTrue($model->hasAppended('children'));
        }
    }

    /**
     * Test Model - Children Appends
     * Children attribute can be Collection | null
     */
    public function testChildrenAppends(): void
    {
        $model = new MenuItemsModel();

        $this->assertNull($model->children);
        $mock            = $this->createMock(Collection::class);
        $model->children = $mock;
        $this->assertEquals($mock, $model->children);

        $this->expectException(TypeError::class);
        $model->children = 101;
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $total = 1;
        $model = new MenuItemsModel();
        MenusModelFactory::new()
            ->has(MenuItemsModelFactory::new()->count(1), 'items')
            ->count(1)
            ->create();

        $this->assertEquals($this->tablename, $model->getTable());
        $this->assertEquals($total, $model->get()->count());
    }

    /**
     * Test model relationships
     */
    public function test_BelongsTo(): void
    {
        $total = 1;
        $model = new MenuItemsModel();
        MenusModelFactory::new()
            ->has(MenuItemsModelFactory::new()->count(1), 'items')
            ->count(1)
            ->create();

        $this->assertEquals($total, $model->first()->menu->count());
    }
}
