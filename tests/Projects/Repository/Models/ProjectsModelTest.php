<?php

declare(strict_types=1);

namespace Projects\Repository\Model;

use App\Modules\Projects\Repository\Models\ProjectsModel;
use Database\Factories\ProjectsModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class ProjectsModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'projects';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = [
            'id',
            'title',
            'description',
            'image',
            'isgithub',
            'url',
            'orderby',
            'active',
            'created_at',
            'updated_at',
        ];

        $model = new ProjectsModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEqualsCanonicalizing($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $total = 1;
        $model = new ProjectsModel();
        ProjectsModelFactory::new()
            ->count(1)
            ->create();

        $this->assertEquals($this->tablename, $model->getTable());
        $this->assertEquals($total, $model->get()->count());
    }
}
