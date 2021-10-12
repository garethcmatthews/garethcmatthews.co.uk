<?php

declare(strict_types=1);

namespace Contact\Feature\Repository\Models;

use App\Modules\Contact\Repository\Models\ContactBlockedListModel;
use Database\Factories\ContactBlockedListModelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

class ContactBlockedListModelTest extends TestCase
{
    use CreateApplicationTrait;
    use RefreshDatabase;

    /** @var string */
    private $tablename = 'contact_blocked_list';

    /**
     * Test the Model Columns Exist
     * Database Migration works as expected
     */
    public function testModelColumns(): void
    {
        $expected = ['id', 'email', 'created_at', 'updated_at'];

        $model = new ContactBlockedListModel();

        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($this->tablename);
        $this->assertEquals($expected, $columns);
    }

    /**
     * Test model
     */
    public function testModel(): void
    {
        $expectTotal = 1;
        $model       = new ContactBlockedListModel();
        ContactBlockedListModelFactory::new()
            ->count(1)
            ->create();

        $this->assertEquals($expectTotal, $model->get()->count());
        $this->assertEquals($this->tablename, $model->getTable());
    }
}
