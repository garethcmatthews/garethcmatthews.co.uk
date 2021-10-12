<?php

declare(strict_types=1);

namespace Links\Feature\Repository\Models;

use App\Modules\Links\Repository\Models\LinksModel;
use Database\Factories\LinksModelFactory;
use Database\Factories\LinksTagsModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class LinksModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'links';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = ['id', 'title', 'description', 'url', 'image', 'active', 'created_at', 'updated_at'];
        $model    = new LinksModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEquals($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $expectTotal = 1;
        $model       = new LinksModel();
        LinksModelFactory::new()
            ->count(1)
            ->create();

        $this->assertEquals($expectTotal, $model->get()->count());
        $this->assertEquals($this->tablename, $model->getTable());
    }

    /**
     * Test model relationships
     */
    public function testModel_BelongsToMany(): void
    {
        $expectTotal = 1;
        $model       = new LinksModel();
        LinksModelFactory::new()
            ->has(LinksTagsModelFactory::new()->count(1), 'tags')
            ->count(1)
            ->create();

        $this->assertEquals($expectTotal, $model->first()->tags->count());
    }
}
