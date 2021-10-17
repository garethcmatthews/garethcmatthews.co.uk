<?php

declare(strict_types=1);

namespace Technology\Repository\Model;

use App\Modules\Technology\Repository\Models\TechnologyItemsModel;
use Database\Factories\TechnologyItemsModelFactory;
use Database\Factories\TechnologyModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class TechnologyItemsModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'technology_items';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = ['id', 'title', 'url', 'primary', 'active', 'orderby', 'technology_id', 'created_at', 'updated_at'];
        $model    = new TechnologyItemsModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEqualsCanonicalizing($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $total = 1;
        $model = new TechnologyItemsModel();
        TechnologyModelFactory::new()
            ->has(TechnologyItemsModelFactory::new()->count(1), 'items')
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
        $model = new TechnologyItemsModel();
        TechnologyModelFactory::new()
            ->has(TechnologyItemsModelFactory::new()->count(1), 'items')
            ->count(1)
            ->create();

        $this->assertEquals($total, $model->first()->technology->count());
    }
}
