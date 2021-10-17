<?php

declare(strict_types=1);

namespace Links\Feature\Repository\Models;

use App\Modules\Links\Repository\Models\LinksTagsModel;
use Database\Factories\LinksModelFactory;
use Database\Factories\LinksTagsModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class LinksTagsModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'links_tags';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = ['id', 'name', 'title', 'created_at', 'updated_at'];
        $model    = new LinksTagsModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);

        $this->assertEqualsCanonicalizing($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $expectTotal = 1;
        $model       = new LinksTagsModel();
        LinksTagsModelFactory::new()
            ->count(1)
            ->create();

        $this->assertEquals($expectTotal, $model->get()->count());
        $this->assertEquals($this->tablename, $model->getTable());
    }

    /**
     * Test model relationships
     */
    public function testModelBelongsToMany(): void
    {
        $expectTotal = 1;
        $model       = new LinksTagsModel();
        LinksTagsModelFactory::new()
            ->has(LinksModelFactory::new()->count(1), 'links')
            ->count(1)
            ->create();

        $this->assertEquals($expectTotal, $model->first()->links->count());
    }
}
