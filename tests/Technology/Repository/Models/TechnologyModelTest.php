<?php

declare(strict_types=1);

namespace Technology\Repository\Model;

use App\Modules\Technology\Repository\Models\TechnologyModel;
use Database\Factories\TechnologyItemsModelFactory;
use Database\Factories\TechnologyModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class TechnologyModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'technology';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = ['id', 'description', 'tag', 'active', 'created_at', 'updated_at'];
        $model    = new TechnologyModel();
        $columns  = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEquals($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $total = 1;
        $model = new TechnologyModel();
        TechnologyModelFactory::new()
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
        $model = new TechnologyModel();
        TechnologyModelFactory::new()
            ->has(TechnologyItemsModelFactory::new()->count(1), 'items')
            ->count(1)
            ->create();

        $this->assertEquals($total, $model->first()->items->count());
    }
}
