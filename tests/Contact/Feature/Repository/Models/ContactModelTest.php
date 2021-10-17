<?php

declare(strict_types=1);

namespace Contact\Feature\Repository\Models;

use App\Modules\Contact\Repository\Models\ContactModel;
use Database\Factories\ContactModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class ContactModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'contact';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = ['id', 'fullname', 'company', 'email', 'reason', 'message', 'created_at', 'updated_at'];

        $model = new ContactModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEqualsCanonicalizing($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $expectTotal = 1;
        $model       = new ContactModel();
        ContactModelFactory::new()
            ->count(1)
            ->create();

        $this->assertEquals($expectTotal, $model->get()->count());
        $this->assertEquals($this->tablename, $model->getTable());
    }
}
